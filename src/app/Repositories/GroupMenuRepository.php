<?php


namespace App\Repositories;


use App\Models\GroupMenu;
use App\Traits\baseRepositoryTrait;

class GroupMenuRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(GroupMenu $model)
    {
        $this->model = $model;
    }

    public function init()
    {
        return $this->model;
    }

    public function deleteByGroupId($group_id)
    {
        return $this->model->where('group_id',$group_id)->delete();
    }
}
