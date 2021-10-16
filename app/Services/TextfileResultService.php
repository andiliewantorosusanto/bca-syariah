<?php


namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TextfileResultImport;
use App\Repositories\TextfileResultRepository;
use App\Traits\paginatorTrait;
use GrahamCampbell\ResultType\Result;
use Illuminate\Support\Facades\Storage;

class TextfileResultService
{
    use paginatorTrait;

    protected $repository,$logTextfileResultService;

    public function __construct(
        TextfileResultRepository $repository,
        LogTextfileResultService $logTextfileResultService
    )
    {
        $this->repository = $repository;
        $this->logTextfileResultService= $logTextfileResultService;
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
        $text_file_content = "";

        foreach($data as $e){
            $text_file_content .= $e->batch_no.','.$e->nomor_rekening.','.$e->jenis_mutasi.','.$e->trx_code.','.$e->amount.','.$e->sign.','.$e->deskripsi.','.$e->status_va.','.$e->ket_validasi.','.$e->sts_proses.','.$e->ket_proses;
        }

        Storage::disk('local')->put($file_path_text_file.$file_name_text_file, $text_file_content);

        return array(
            "file_name_text_file" => $file_name_text_file,
            "file_path_text_file" => $file_path_text_file
        );
    }

    public function saveFile($file)
    {
        $file_path_excel = "upload/excel/";
        $path = Storage::putFile($file_path_excel,$file);
        $file_name_excel = basename($path);

        return array(
            "file_name_excel"   => $file_name_excel,
            "file_path_excel"   => $file_path_excel
        );
    }
}
