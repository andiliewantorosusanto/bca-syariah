<?php


namespace App\Repositories;

use App\Models\CSF\vrys_autodebetkonsumenbermasalah_syariah;
use App\Traits\baseRepositoryTrait;

class vrys_autodebetkonsumenbermasalah_syariahRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(vrys_autodebetkonsumenbermasalah_syariah $model)
    {
        $this->model = $model;
    }

    public function init()
    {
        return $this->model;
    }

    public function getTodayDueDate()
    {
        //2021-05-11
        //return $this->model->whereDate('tgljatuhtempo',date('Y-m-d'))->get();
        return $this->model->whereDate('tgljatuhtempo','2021-05-11')->get();
    }
}
