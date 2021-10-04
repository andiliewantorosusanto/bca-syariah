<?php


namespace App\Repositories;


use App\Models\Group;
use App\Traits\baseRepositoryTrait;

class GroupRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(Group $model)
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