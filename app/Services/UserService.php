<?php


namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\paginatorTrait;

class UserService
{
    use paginatorTrait;

    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function pagination($request)
    {
        $limit = $request->input('limit','15');
        $query = $this->repository->init();

        if ( isset($request->sort) && $request->sort != "undefined"){
            $query = $this->repository->orderBy($query, $request->sort, $request->order);
        }

        $result = $this->repository->pagination($query, $limit);

        return $this->convertPaginator($result,'users');
    }

    public function getById($id)
    {
        return $this->repository->getById($id);
    }

    public function update($id, $request)
    {
        return $this->repository->update($id, $request->all());
    }

    public function create($request)
    {
        return $this->repository->create($request->all(),$request->user()->id);
    }

    public function delete($id)
    {
        $model = $this->repository->getById($id);
        return $this->repository->destroy($model);
    }

    public function toggle($id)
    {
        $user = $this->repository->getById($id);
        if ( $user->sts === true)
            return $this->repository->update($id, ['sts' => false]);
        return $this->repository->update($id, ['sts' => true]);
    }
}
