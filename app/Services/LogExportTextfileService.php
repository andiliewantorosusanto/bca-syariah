<?php


namespace App\Services;


use App\Repositories\LogExportTextfileRepository;
use App\Traits\paginatorTrait;

class LogExportTextfileService
{
    use paginatorTrait;

    protected $repository;

    public function __construct(LogExportTextfileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function pagination($request)
    {
        $limit      = $request->input('limit','15');
        $query = $this->repository->init();

        if ( isset($request->name)){
            $query = $this->repository->filterName($query, $request->name);
        }

        $result = $this->repository->pagination($query, $limit);
        return $this->convertPaginator($result);
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
        return $this->repository->create($request->all());
    }

    public function delete($id)
    {
        $model = $this->repository->getById($id);
        return $this->repository->destroy($model);
    }
}