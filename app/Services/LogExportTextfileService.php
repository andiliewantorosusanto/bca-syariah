<?php


namespace App\Services;


use App\Repositories\LogExportTextfileRepository;
use App\Traits\paginatorTrait;

class LogExportTextfileService
{
    use paginatorTrait;

    protected $repository;

    public function __construct(LogExportTextfileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getTodayExportCount()
    {
        return count($this->repository->getTodayExport());
    }

    public function insertLogExport($batch_no,$file_path,$file_name,$user_id)
    {
        $log_export_textfile = array(
            "batch_no"                  => $batch_no,
            "file_path"                 => $file_path,
            "file_name"                 => $file_name,
            'created_by'                => $user_id
        );

        return $this->repository->create($log_export_textfile,$user_id);
    }

    public function getByBatchNo($batch_no)
    {
        return $this->repository->getByBatchNo($batch_no);
    }
}
