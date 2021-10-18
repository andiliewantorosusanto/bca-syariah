<?php


namespace App\Services;


use App\Repositories\MenuRepository;
use App\Traits\paginatorTrait;

class MenuService
{
    use paginatorTrait;

    protected $repository;

    public function __construct(MenuRepository $repository)
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

        if( isset($request->search) && $request->search != "") {
            $menu = new Menu();
            $columns = $menu->getFillable();

            foreach($columns as $column){
                $query = $this->repository->filter($query,$column,$request->search);
            }
        }

        $result = $this->repository->pagination($query, $limit);

        return $this->convertPaginator($result,'menus');
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
}
