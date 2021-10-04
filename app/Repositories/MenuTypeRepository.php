<?php


namespace App\Repositories;


use App\Models\MenuType;
use App\Traits\baseRepositoryTrait;

class MenuTypeRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(MenuType $model)
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
