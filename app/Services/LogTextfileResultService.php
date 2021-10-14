<?php


namespace App\Services;


use App\Repositories\LogTextfileResultRepository;
use App\Traits\paginatorTrait;

class LogTextfileResultService
{
    use paginatorTrait;

    protected $repository;

    public function __construct(LogTextfileResultRepository $repository)
    {
        $this->repository = $repository;
    }

    public function browse($request)
    {
        return $this->repository->browse($request->search_column,$request->search_value,$request->sort);
    }

    public function insertLogTextfileResult($batch_no,$file_path_textfile,$file_name_textfile,$file_path_excel,$file_name_excel,$user_id)
    {
        $log_textfile_result = array(
            "batch_no"                  => $batch_no,
            "file_path_textfile"        => $file_path_textfile,
            "file_name_textfile"        => $file_name_textfile,
            "file_path_excel"           => $file_path_excel,
            "file_name_excel"           => $file_name_excel,
            "created_by"                => $user_id,
            "status_export"             => 0
        );

        return $this->repository->create($log_textfile_result,$user_id);
    }

    public function getByBatchNo($batch_no,$status_export)
    {
        return $this->repository->getByBatchNo($batch_no,$status_export);
    }

    public function getNextBatchNo()
    {
        $batch_no = count($this->repository->getAllBatch()) + 1;
        $batch_no = str_pad($batch_no,10, "0", STR_PAD_LEFT);

        return $batch_no;
    }
}
