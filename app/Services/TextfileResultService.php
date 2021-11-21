<?php


namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TextfileResultImport;
use App\Repositories\CorAccountInfoRepository;
use App\Repositories\CorAccountRepository;
use App\Repositories\TextfileResultRepository;
use App\Traits\paginatorTrait;
use GrahamCampbell\ResultType\Result;
use Illuminate\Support\Facades\Storage;

class TextfileResultService
{
    use paginatorTrait;

    protected $repository,$logTextfileResultService,$corAccountRepository,$corAccountInfoRepository;

    public function __construct(
        TextfileResultRepository $repository,
        LogTextfileResultService $logTextfileResultService,
        CorAccountRepository $corAccountRepository,
        CorAccountInfoRepository $corAccountInfoRepository
    )
    {
        $this->repository = $repository;
        $this->logTextfileResultService= $logTextfileResultService;
        $this->corAccountRepository = $corAccountRepository;
        $this->corAccountInfoRepository = $corAccountInfoRepository;
    }

    public function pagination($request)
    {
        $limit = $request->input('limit','1000');
        $query = $this->repository->init();

        if(isset($request->batch_no)) {
            $query = $this->repository->filterBatchNo($query,$request->batch_no);
        }

        $result = $this->repository->pagination($query, $limit);
        return $this->convertPaginator($result);
    }

    public function import($request)
    {
        $batch_no = $this->logTextfileResultService->getNextBatchNo();
        $user_id = $request->user()->id;
        Excel::import(new TextfileResultImport($batch_no,$user_id), $request->file('file')->store('temp'));
        $data = $this->repository->getByBatchNoAndKetProses($batch_no);
        $text_file = $this->generateTextfile($data);
        $excel_file = $this->saveFile($request->file('file'));
        $result = $this->logTextfileResultService->insertLogTextfileResult($batch_no,$text_file['file_path_text_file'],$text_file['file_name_text_file'],$excel_file['file_path_excel'],$excel_file['file_name_excel'],$user_id);
        return $result;
    }

    public function generateTextfile($data)
    {
        $file_name_text_file = "BCAS_".date('Ymd').'.txt';
        $file_path_text_file = "upload/textfile/";

        $prefixCode = "0CO";
        $rekeningDebit = "2050070070";
        $totalDebit = 0;
        $totalTransaction = 0;
        $deskripsi = "AUTODEBET(NONBCA)";
        $tanggal = date('d/m/Y');
        $tanggalHeader = date('Ymd');
        $text_file_content = "";

        $body = "";
        foreach($data as $e){
            if($e->ket_proses == "SUKSES") {
                $totalDebit += (float) $e->amount;
                $totalTransaction += 1;
                $body .= str_pad('1'.$e->nomor_rekening,20).str_pad(number_format($e->amount, 2, ".", ","),35,' ',STR_PAD_LEFT).str_pad($e->corAccountInfo?->AtasNama,35).str_pad('AUTODEBET',18).str_pad($e->deskripsi,18).$e->corAccount?->AccountName."\r\n";
            }
        }
        $header = str_pad($prefixCode.$tanggalHeader.$rekeningDebit,30).str_pad(number_format($totalDebit, 2, ".", ","),35," ",STR_PAD_LEFT).str_pad($totalTransaction,5,"0",STR_PAD_LEFT).str_pad($deskripsi."   ".$tanggal,143)."P-Accepted"."\r\n";

        $text_file_content = $header.$body;

        $unique_name = uniqid().'.txt';

        Storage::disk('local')->put($file_path_text_file.$unique_name, $text_file_content);

        return array(
            "file_name_text_file" => $file_name_text_file,
            "file_path_text_file" => $file_path_text_file.$unique_name
        );
    }

    public function saveFile($file)
    {
        $file_path_excel = "upload/excel/";
        $path = Storage::putFile($file_path_excel,$file);
        $file_name_excel = basename($path);

        return array(
            "file_name_excel"   => $file_name_excel,
            "file_path_excel"   => $file_path_excel.$file_name_excel
        );
    }
}
