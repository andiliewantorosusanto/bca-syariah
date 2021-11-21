<?php


namespace App\Repositories;


use App\Models\TextfileResult;
use App\Traits\baseRepositoryTrait;

class TextfileResultRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(TextfileResult $model)
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

    public function filterBatchNo($query, $batch_no)
    {
        return $query->where('batch_no',$batch_no);
    }

    public function getByBatchNoAndKetProses($batch_no,$ket_proses = 'sukses')
    {
        return $this->model->lock('WITH(NOLOCK)')->with(['corAccount','corAccountInfo'])->where('batch_no',$batch_no)->where('ket_proses','like',$ket_proses)->get();
    }

    public function getByBatchNo($batch_no)
    {
        return $this->model->lock('WITH(NOLOCK)')->where('batch_no',$batch_no)->get();
    }

    public function getCountByBatchNo($batch_no)
    {
        return $this->model->lock('WITH(NOLOCK)')->where('batch_no',$batch_no)->count();
    }
}
