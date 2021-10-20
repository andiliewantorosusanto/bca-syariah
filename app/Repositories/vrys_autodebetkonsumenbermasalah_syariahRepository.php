<?php


namespace App\Repositories;

use App\Models\CSF\vrys_autodebetkonsumenbermasalah_syariah;
use App\Traits\baseRepositoryTrait;
use Illuminate\Support\Facades\DB;

class vrys_autodebetkonsumenbermasalah_syariahRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(vrys_autodebetkonsumenbermasalah_syariah $model)
    {
        $this->model = $model;
    }

    public function init()
    {
        return $this->model;
    }

    public function getTodayDueDate()
    {
        //2021-05-11
        //return $this->model->whereDate('tgljatuhtempo',date('Y-m-d'))->get();
        return $this->model->whereDate('tgljatuhtempo','2021-05-11')->get();
    }

    public function import()
    {
        $unique = uniqid();
        DB::connection('othercsf')->statement("EXEC SP_VA_CreateTempJob 'SP_VA_ImportViewKonsumenBermasalahToTable_".$unique."', 'EXEC OtherCSF.dbo.SP_ImportViewKonsumenBermasalahToTable ''".$unique."'' '");
        DB::connection('othercsf')->statement("msdb..sp_start_job @job_name='SP_VA_ImportViewKonsumenBermasalahToTable_".$unique."'");
        return $unique;
    }

    public function checkJobs($unique)
    {
        return DB::connection('othercsf')->table('jobs')->select('status')->where('token',$unique)->where('status','like','FINISH INSERT OVERDUE')->first();
    }
}
