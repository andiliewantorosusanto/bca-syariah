<?php


namespace App\Repositories;


use App\Models\User;
use App\Traits\baseRepositoryTrait;

class UserRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(User $model)
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

    public function getByUsername($username)
    {
        return $this->model->where('username',$username)->first();
    }
}
