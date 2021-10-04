<?php


namespace App\Repositories;


use App\Models\GenerateTextfile;
use App\Traits\baseRepositoryTrait;

class GenerateTextfileRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(GenerateTextfile $model)
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
