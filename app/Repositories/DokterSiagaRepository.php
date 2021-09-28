<?php


namespace App\Repositories;


use App\Models\DokterSiaga;
use App\Traits\baseRepositoryTrait;

class DokterSiagaRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(DokterSiaga $model)
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

    public function filterName($query, $name)
    {
        return $query->where('name', 'like' ,'%'.$name.'%');
    }
}
