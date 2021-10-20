<?php


namespace App\Repositories;

use App\Models\CSF\vrys_autodebetnormal_syariah;
use App\Traits\baseRepositoryTrait;
use Illuminate\Support\Facades\DB;

class vrys_autodebetnormal_syariahRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(vrys_autodebetnormal_syariah $model)
    {
        $this->model = $model;
    }

    public function init()
    {
        return $this->model;
    }

    public function getTodayDueDate()
    {
        //uncoment this later
        //return $this->model->whereDate('tgljatuhtempo',date('Y-m-d'))->get();
        return $this->model->whereDate('tgljatuhtempo','2020-05-28')->get();
    }

    public function import()
    {
        $unique = uniqid();
        DB::connection('othercsf')->statement("EXEC SP_VA_CreateTempJob 'SP_VA_ImportViewNormalToTable_".$unique."', 'EXEC OtherCSF.dbo.SP_ImportViewNormalToTable ''".$unique."'' '");
        DB::connection('othercsf')->statement("msdb..sp_start_job @job_name='SP_VA_ImportViewNormalToTable_".$unique."'");
        return $unique;
    }

    public function checkJobs($unique)
    {
        return DB::connection('othercsf')->table('jobs')->select('status')->where('token',$unique)->where('status','like','FINISH INSERT NORMAL')->first();
    }
}
