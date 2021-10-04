<?php


namespace App\Repositories;


use App\Models\LogTextfileResult;
use App\Traits\baseRepositoryTrait;

class LogTextfileResultRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(LogTextfileResult $model)
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
}
