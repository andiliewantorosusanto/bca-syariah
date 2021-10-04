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

    public function pagination($query, $limit)
    {
        return $query->paginate($limit);
    }
}
