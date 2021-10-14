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

    public function deleteByUserId($user_id)
    {
        return $this->model->where('user_id',$user_id)->delete();
    }

    // public function deleteByWorkgroupIdAndUserId($workgroup_id, $user_id)
    // {
    //     return $this->model->where('workgroup_id', $workgroup_id)->where('user_id', $user_id)->delete();
    // }

    // public function getByWorkgroupId($id)
    // {
    //     return $this->model->where('workgroup_id', $id)->join('users','user_workgroup.user_id','=','users.id')->select('users.id','users.name','users.email','users.nrp','users.status','users.birth_date','users.profile_image_url','users.assign_location','users.role','user_workgroup.created_at as join_date')->get();
    // }

    // public function getActiveUsersByWorkgroupId($id)
    // {
    //     return $this->model->where('workgroup_id', $id)->where('users.mobile_task_available', 'active')->join('users','user_workgroup.user_id','=','users.id')->select('users.id','users.name','users.email','users.nrp','users.status','users.birth_date','users.profile_image_url','users.assign_location','users.role','user_workgroup.created_at as join_date')->get();
    // }

    // public function getWorkgroupIdsByLoggedUser()
    // {
    //     return $this->model->where('user_id',auth()->user()->id)->pluck('workgroup_id')->toArray();
    // }
}
