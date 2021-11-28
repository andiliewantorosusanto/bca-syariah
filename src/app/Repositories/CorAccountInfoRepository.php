<?php


namespace App\Repositories;


use App\Models\CSF\CorAccountInfo;
use App\Traits\baseRepositoryTrait;

class CorAccountInfoRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(CorAccountInfo $model)
    {
        $this->model = $model;
    }

    public function init()
    {
        return $this->model;
    }

    public function getByWhereInNoRek($noRek)
    {
        return $this->model->lock('WITH(NOLOCK)')->select('noRek,noPin,noRekBank,atasNama')->whereIn('noRek',$noRek)->get();
    }
}
