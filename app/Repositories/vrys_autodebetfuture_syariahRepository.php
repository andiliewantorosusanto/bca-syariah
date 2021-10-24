<?php


namespace App\Repositories;


use App\Models\CSF\vrys_autodebetfuture_syariah;
use App\Traits\baseRepositoryTrait;
use Illuminate\Support\Facades\DB;

class vrys_autodebetfuture_syariahRepository
{
    use baseRepositoryTrait;

    protected $model;

    public function __construct(vrys_autodebetfuture_syariah $model)
    {
        $this->model = $model;
    }

    public function init()
    {
        return $this->model;
    }

    public function getByDueDate($duedate)
    {
        //uncomment this later
        //return $this->model->whereBetween('tgljatuhtempo',[date('Y-m-d'),$duedate])->get();
        return $this->model->select(DB::raw('count(*) as totalData'),DB::raw('SUM(installment) as totalAmount'))->whereBetween('tgljatuhtempo',['2020-06-21',date('Y-m-d')])->first();
    }

    public function import($duedate)
    {
        $unique = uniqid();
        DB::connection('othercsf')->statement("EXEC SP_VA_CreateTempJob 'SP_VA_ImportViewFutureToTable_".$unique."', 'EXEC OtherCSF.dbo.SP_ImportViewFutureToTable ''".$unique."'',''".$duedate."'' '");
        DB::connection('othercsf')->statement("msdb..sp_start_job @job_name='SP_VA_ImportViewFutureToTable_".$unique."'");

        return $unique;
    }

    public function checkJobs($unique)
    {
        return DB::connection('othercsf')->table('jobs')->select('status')->where('token',$unique)->where('status','like','FINISH INSERT FUTURE')->first();
    }
}
