<?php


namespace App\Services;

use App\Models\User;
use App\Repositories\GroupUserRepository;
use App\Repositories\UserRepository;
use App\Traits\paginatorTrait;

class UserService
{
    use paginatorTrait;

    protected $repository;
    protected $groupUserRepository;

    public function __construct(
        UserRepository $repository,
        GroupUserRepository $groupUserRepository
        )
    {
        $this->repository = $repository;
        $this->groupUserRepository = $groupUserRepository;
    }

    public function pagination($request)
    {
        $limit = $request->input('limit','15');
        $query = $this->repository->init();

        if ( isset($request->sort) && $request->sort != "undefined"){
            $query = $this->repository->orderBy($query, $request->sort, $request->order);
        }

        if( isset($request->search) && $request->search != "") {
            $user = new User();
            $columns = $user->getFillable();

            foreach($columns as $column){
                $query = $this->repository->filter($query,$column,$request->search);
            }
        }

        $result = $this->repository->pagination($query, $limit);

        return $this->convertPaginator($result,'users');
    }

    public function getById($id)
    {
        return $this->repository->getById($id);
    }


    public function getGroup($id)
    {
        return $this->repository->getGroup($id);
    }

    public function update($id, $request)
    {
        return $this->repository->update($id, $request->all());
    }

    public function create($request)
    {
        return $this->repository->create($request->all(),$request->user()->id);
    }

    public function updateGroups($id,$request)
    {
        $this->groupUserRepository->deleteByUserId($id);

        foreach($request->group_ids as $group_id) {
            $input = ['group_id' => $group_id, 'user_id' => $id];
            $this->groupUserRepository->createWithoutTrace($input);
        }
        return [
            'message' => 'ok'
        ];
    }

    public function delete($id)
    {
        $model = $this->repository->getById($id);
        return $this->repository->destroy($model);
    }

    public function toggle($id)
    {
        $user = $this->repository->getById($id);
        if ( $user->sts == true)
            return $this->repository->update($id, ['sts' => false]);
        return $this->repository->update($id, ['sts' => true]);
    }
}
