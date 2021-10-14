<?php


namespace App\Repositories;


use App\Models\CSF\vrys_autodebetfuture_syariah;
use App\Traits\baseRepositoryTrait;

class vrys_autodebetfuture_syariahRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(vrys_autodebetfuture_syariah $model)
    {
        $this->model = $model;
    }

    public function init()
    {
        return $this->model;
    }

    public function getByDueDate($duedate)
    {
        //uncomment this later
        //return $this->model->whereBetween('tgljatuhtempo',[date('Y-m-d'),$duedate])->get();
        return $this->model->whereBetween('tgljatuhtempo',['2020-06-21',date('Y-m-d')])->get();
    }
}
