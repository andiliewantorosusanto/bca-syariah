<?php


namespace App\Repositories;


use App\Models\TextfileResultRepository;
use App\Traits\baseRepositoryTrait;

class TextfileResultRepositoryRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(TextfileResultRepository $model)
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
