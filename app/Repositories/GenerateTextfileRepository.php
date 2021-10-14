<?php


namespace App\Repositories;


use App\Models\GenerateTextfile;
use App\Traits\baseRepositoryTrait;

class GenerateTextfileRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(GenerateTextfile $model)
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

    public function getAllBatch()
    {
        return $this->model->select('batch_no')->orderByDesc('batch_no')->groupBy('batch_no')->get();
    }

    public function updateGenerateTextFile($batch_no,$sts,$auto_debet_type,$update_data)
    {
        return $this->model
        ->where('batch_no',$batch_no)
        ->where('sts',$sts)
        ->where('auto_debet_type',$auto_debet_type)
        ->update($update_data);
    }

    public function getGenerateTextFile($batch_no,$sts,$auto_debet_type)
    {
        return $this->model
        ->where('batch_no',$batch_no)
        ->where('sts',$sts)
        ->where('auto_debet_type',$auto_debet_type)->get();
    }

}
