<?php


namespace App\Services;


use App\Repositories\GenerateTextfileRepository;
use App\Traits\paginatorTrait;
use Illuminate\Support\Facades\Storage;

class GenerateTextfileService
{
    use paginatorTrait;

    protected $repository;
    protected $logExportTextfileService;

    public function __construct(
        GenerateTextfileRepository $repository,
        LogExportTextfileService $logExportTextfileService
    )
    {
        $this->repository = $repository;
        $this->logExportTextfileService = $logExportTextfileService;
    }

    public function createTextfile($data,$auto_debet_type,$user_id)
    {
        $batch_no = $this->getNextBatchNo();
        $this->insertGenerateTextfile($data,$batch_no,$auto_debet_type,$user_id);
        $file_name = $this->generateTextfile($batch_no,$auto_debet_type,$user_id);
        $this->logExportTextfileService->insertLogExport($batch_no,$file_name,$file_name,$user_id);
        return $batch_no;
    }

    public function insertGenerateTextfile($data,$batch_no,$auto_debet_type,$user_id)
    {
        foreach($data as $d) {
            $generate_text_file = array(
                "no_rek"                    => $d->norek,
                "no_pin"                    => $d->nopin,
                "cust_name"                 => $d->custname,
                "account_no"                => $d->accountno,
                "installment"               => $d->installment,
                "police_no"                 => $d->policeno,
                "periode_ke"                => $d->periodeke,
                "tgl_jatuh_tempo"           => $d->tgljatuhtempo,
                "tgl_awal_create_text_file" => $d->tglawalcreatetextfile,
                "tgl_akhir_create_text_file"=> $d->tglakhircreatetextfile,
                "free_field_1"              => $d->freefield1,
                "free_field_2"              => $d->freefield2,
                "free_field_3"              => $d->freefield3,
                "atas_nama_bank"            => $d->atasnamabank,
                "jf_due_date"               => $d->jfduedate,
                "jumlah_tunggakan"          => $d->jumlahtunggakan,
                "packet_name"               => $d->packetname,
                "kode_bank"                 => $d->kodebank,
                "no_rek_bank"               => $d->norekbank,
                "bank"                      => $d->bank,
                "sts"                       => "0",
                "batch_no"                  => $batch_no,
                "auto_debet_type"           => $auto_debet_type,
                'created_by'                => $user_id,
                'updated_by'                => $user_id
            );

            $this->repository->create($generate_text_file,$user_id);
        }
    }

    public function getNextBatchNo()
    {
        $batch_no = count($this->repository->getAllBatch()) + 1;
        $batch_no = str_pad($batch_no,10, "0", STR_PAD_LEFT);

        return $batch_no;
    }

    public function generateTextfile($batch_no,$auto_debet_type,$user_id)
    {
        $today_export_count = $this->logExportTextfileService->getTodayExportCount();
        $text_file_name = "BCAS_".date('Ymd');
        if($today_export_count > 1) $text_file_name = $text_file_name.'_n';
        $text_file_name .= '.txt';

        $update_data = array(
            "sts" => "1",
            "updated_by" => $user_id
        );

        $this->repository->updateGenerateTextFile($batch_no,'0',$auto_debet_type,$update_data);
        $generate_text_files = $this->repository->getGenerateTextFile($batch_no,'1',$auto_debet_type);

        $text_file_content = "";

        foreach($generate_text_files as $e){
            $text_file_content .= '4012,'.$e->account_no.','.round($e->installment,0).',+,'.$e->no_rek.$e->no_pin."\n";
        }

        Storage::disk('local')->put($text_file_name, $text_file_content);

        return $text_file_name;
    }
}
