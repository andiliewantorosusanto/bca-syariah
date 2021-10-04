<?php


namespace App\Repositories;


use App\Models\Menu;
use App\Traits\baseRepositoryTrait;

class MenuRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(Menu $model)
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
