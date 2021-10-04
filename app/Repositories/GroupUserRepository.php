<?php


namespace App\Repositories;


use App\Models\GroupUser;
use App\Traits\baseRepositoryTrait;

class GroupUserRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(GroupUser $model)
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
