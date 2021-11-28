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

    public function getMenu($id)
    {
        return $this->model->lock('WITH(NOLOCK)')->where('id', $id)->first()->menus()->get();
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
