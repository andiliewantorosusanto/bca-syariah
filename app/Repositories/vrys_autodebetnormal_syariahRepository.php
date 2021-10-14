<?php


namespace App\Repositories;

use App\Models\CSF\vrys_autodebetnormal_syariah;
use App\Traits\baseRepositoryTrait;

class vrys_autodebetnormal_syariahRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(vrys_autodebetnormal_syariah $model)
    {
        $this->model = $model;
    }

    public function init()
    {
        return $this->model;
    }

    public function getTodayDueDate()
    {
        //uncoment this later
        //return $this->model->whereDate('tgljatuhtempo',date('Y-m-d'))->get();
        return $this->model->whereDate('tgljatuhtempo','2020-05-28')->get();
    }
}
