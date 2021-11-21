<?php


namespace App\Repositories;


use App\Models\CSF\CorAccount;
use App\Traits\baseRepositoryTrait;

class CorAccountRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(CorAccount $model)
    {
        $this->model = $model;
    }

    public function init()
    {
        return $this->model;
    }

    public function getByWhereInNoRek($noRek)
    {
        return $this->model->lock('WITH(NOLOCK)')->select('noRek,noPin,accountName')->whereIn('noRek',$noRek)->get();
    }
}
