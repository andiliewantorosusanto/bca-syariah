<?php


namespace App\Repositories;


use App\Models\LogTextfileResult;
use App\Traits\baseRepositoryTrait;
use Illuminate\Database\Eloquent\Builder;

class LogTextfileResultRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(LogTextfileResult $model)
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

    public function getByBatchNoAndExportStatus($batch_no,$export_status)
    {
        return $this->model->lock('WITH(NOLOCK)')->where('batch_no',$batch_no)->where('status_export',$export_status)->first();
    }


    public function getByBatchNo($batch_no)
    {
        return $this->model->lock('WITH(NOLOCK)')->where('batch_no',$batch_no)->first();
    }

    public function getAllBatch()
    {
        return $this->model->lock('WITH(NOLOCK)')->select('batch_no')->orderByDesc('batch_no')->groupBy('batch_no')->get();
    }

    public function browse($search_column,$search_value,$sort)
    {
        return $this->model->lock('WITH(NOLOCK)')->where($search_column,'like','%'.$search_value.'%')->orderBy($sort)->withCount('textfileresults')->with('updatedby')->get();
    }

    public function browseUpdatedBy($search_value,$sort)
    {
        return $this->model->lock('WITH(NOLOCK)')->whereHas('updatedby',function (Builder $query) use ($search_value){
            $query->where('nama','like','%'.$search_value.'%')->orWhere('username','like','%'.$search_value.'%');
        })->orderBy($sort)->withCount('textfileresults')->with('updatedby')->get();
    }
}
