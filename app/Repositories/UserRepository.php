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

    public function getGroup($id)
    {
        return $this->model->where('id', $id)->first()->groups()->get();
    }

    public function getByUsername($username)
    {
        return $this->model->where('username',$username)->first();
    }

    public function filter($query,$column,$keyword)
    {
        return $query->orWhere($column, 'LIKE' ,'%'.$keyword.'%');
    }

    public function orderBy($query,$sort,$order)
    {
        if($order == 'desc')
        {
            return $query->orderByDesc($sort);
        } else {
            return $query->orderBy($sort);
        }
    }
}
