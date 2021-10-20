<?php


namespace App\Repositories;


use App\Models\AutoDebet;
use App\Traits\baseRepositoryTrait;

class AutoDebetRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(AutoDebet $model)
    {
        $this->model = $model;
    }

    public function init()
    {
        return $this->model;
    }

    public function pagination($query, $limit)
    {
        return $query->paginate($limit);
    }

    public function getFuture($duedate)
    {
        //uncomment this later
        //return $this->model->whereBetween('tgljatuhtempo',[date('Y-m-d'),$duedate])->get();
        //return $this->model->whereBetween('tgl_jatuh_tempo',['2020-06-21',date('Y-m-d')])->where('auto_debet_type','future')->get();
        return $this->model->where('auto_debet_type','future')->get();
    }

    public function getNormal()
    {
        //2021-05-11
        //return $this->model->whereDate('tgljatuhtempo',date('Y-m-d'))->get();
        //return $this->model->whereDate('tgl_jatuh_tempo','2021-07-10')->where('auto_debet_type','normal')->get();
        return $this->model->where('auto_debet_type','normal')->get();
    }

    public function getKonsumenBermasalah()
    {
        //2021-05-11
        //return $this->model->whereDate('tgljatuhtempo',date('Y-m-d'))->get();
        //return $this->model->whereDate('tgl_jatuh_tempo','2021-10-18')->where('auto_debet_type','overdue')->get();
        return $this->model->where('auto_debet_type','overdue')->get();
    }
}
