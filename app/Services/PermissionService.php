<?php


namespace App\Services;


use App\Repositories\PermissionRepository;
use App\Repositories\UserPermissionRepository;
use App\Traits\paginatorTrait;

class PermissionService
{
    use paginatorTrait;

    protected $permissionRepository;
    protected $userPermissionRepository;

    public function __construct(PermissionRepository $permissionRepository, UserPermissionRepository $userPermissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->userPermissionRepository = $userPermissionRepository;
    }

    public function getAll()
    {
        return $this->permissionRepository->all();
    }

    public function getUserPermission($id)
    {
        return $this->userPermissionRepository->getByUserIdWithRelation($id);
    }

    public function updateUserPermission($id, $request)
    {
        $this->userPermissionRepository->deleteByUserId($id);
        foreach ($request->permission_id as $permission){
            $this->userPermissionRepository->create(['permission_id' => $permission, 'user_id' => $id]);
        }

        return $this->getUserPermission($id);
    }
}
