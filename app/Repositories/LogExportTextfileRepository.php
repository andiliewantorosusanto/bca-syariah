<?php


namespace App\Repositories;


use App\Models\LogExportTextfile;
use App\Traits\baseRepositoryTrait;

class LogExportTextfileRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(LogExportTextfile $model)
    {
        $this->model = $model;
    }

    public function init()
    {
        return $this->model;
    }

    public function getTodayExport()
    {
        return $this->model->whereDate('created_at',date('Y-m-d'))->get();
    }

    public function getByBatchNo($batch_no)
    {
        return $this->model->where('batch_no',$batch_no)->first();
    }
}
