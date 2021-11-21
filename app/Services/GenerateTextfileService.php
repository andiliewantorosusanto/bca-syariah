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
        $file = $this->generateTextfile($batch_no,$auto_debet_type,$user_id);
        $this->logExportTextfileService->insertLogExport($batch_no,$file['file_path'],$file['file_name'],$user_id);
        return $batch_no;
    }

    public function insertGenerateTextfile($data,$batch_no,$auto_debet_type,$user_id)
    {
        foreach($data as $d) {
            $generate_text_file = array(
                "no_rek"                    => $d->no_rek,
                "no_pin"                    => $d->no_pin,
                "cust_name"                 => $d->cust_name,
                "account_no"                => $d->account_no,
                "installment"               => $d->installment,
                "police_no"                 => $d->police_no,
                "periode_ke"                => $d->periode_ke,
                "tgl_jatuh_tempo"           => $d->tgl_jatuh_tempo,
                "tgl_awal_create_text_file" => $d->tgl_awal_create_text_file,
                "tgl_akhir_create_text_file"=> $d->tgl_akhir_create_text_file,
                "free_field_1"              => $d->free_field_1,
                "free_field_2"              => $d->free_field_2,
                "free_field_3"              => $d->free_field_3,
                "atas_nama_bank"            => $d->atas_nama_bank,
                "jf_due_date"               => $d->jf_due_date,
                "jumlah_tunggakan"          => $d->jumlah_tunggakan,
                "packet_name"               => $d->packet_name,
                "kode_bank"                 => $d->kode_bank,
                "no_rek_bank"               => $d->no_rek_bank,
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

        $file_path = "create/textfile/";
        $unique_name = uniqid().'.txt';

        $this->repository->updateGenerateTextFile($batch_no,'0',$auto_debet_type,$update_data);
        $generate_text_files = $this->repository->getGenerateTextFile($batch_no,'1',$auto_debet_type);

        $text_file_content = "";

        foreach($generate_text_files as $e){
            $text_file_content .= '4012,'.$e->account_no.','.round($e->installment,0).',-,'.$e->no_rek.'-'.$e->no_pin."\n";
        }

        Storage::disk('local')->put($file_path.$unique_name, $text_file_content);

        return array(
            "file_name"   => $text_file_name,
            "file_path"   => $file_path.$unique_name
        );
    }
}
