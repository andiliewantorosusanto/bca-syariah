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

    public function getFuture($token)
    {
        return $this->model->lock('WITH(NOLOCK)')->where('auto_debet_type','future')->where('token',$token)->get();
    }

    public function getNormal($token)
    {
        return $this->model->lock('WITH(NOLOCK)')->where('auto_debet_type','normal')->where('token',$token)->get();
    }

    public function getKonsumenBermasalah($token)
    {
        return $this->model->lock('WITH(NOLOCK)')->where('auto_debet_type','overdue')->where('token',$token)->get();
    }
}
