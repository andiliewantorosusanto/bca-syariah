<?php


namespace App\Services;

use App\Models\Group;
use App\Repositories\GroupMenuRepository;
use App\Repositories\GroupRepository;
use App\Traits\paginatorTrait;

class GroupService
{
    use paginatorTrait;

    protected $repository;
    protected $groupMenuRepository;

    public function __construct(
        GroupRepository $repository,
        GroupMenuRepository $groupMenuRepository
    )
    {
        $this->repository = $repository;
        $this->groupMenuRepository = $groupMenuRepository;
    }

    public function pagination($request)
    {
        $limit = $request->input('limit','15');
        $query = $this->repository->init();

        if ( isset($request->sort) && $request->sort != "undefined"){
            $query = $this->repository->orderBy($query, $request->sort, $request->order);
        }

        if( isset($request->search) && $request->search != "") {
            $group = new Group();
            $columns = $group->getFillable();

            foreach($columns as $column){
                $query = $this->repository->filter($query,$column,$request->search);
            }
        }

        $result = $this->repository->pagination($query, $limit);

        return $this->convertPaginator($result,'groups');
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
        if ( $user->sts == true)
            return $this->repository->update($id, ['sts' => false]);
        return $this->repository->update($id, ['sts' => true]);
    }

    public function getMenu($id)
    {
        return $this->repository->getMenu($id);
    }

    public function updateMenu($id,$request)
    {
        $this->groupMenuRepository->deleteByGroupId($id);

        foreach($request->menu_ids as $menu_id) {
            $input = ['menu_id' => $menu_id, 'group_id' => $id];
            $this->groupMenuRepository->createWithoutTrace($input);
        }
        return [
            'message' => 'ok'
        ];
    }
}
