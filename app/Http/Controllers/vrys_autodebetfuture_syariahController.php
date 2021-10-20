<?php

namespace App\Http\Controllers;

use App\Http\Requests\vrys_autodebetfuture_syariah\generateTodayDueDateRequest;
use App\Http\Requests\vrys_autodebetfuture_syariah\getTodayDueDateRequest;
use App\Jobs\ImportViewFutureSyariah;
use App\Services\vrys_autodebetfuture_syariahService;
use App\Traits\responseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class vrys_autodebetfuture_syariahController extends Controller
{
    use responseTrait;

    protected $service;

    public function __construct(
        vrys_autodebetfuture_syariahService $service,
    )
    {
        $this->service = $service;
    }

    public function importAutoDebet(Request $request)
    {
        $response = $this->service->importAutoDebet($request);
        return $this->response($response);
    }


    public function getByDueDate(getTodayDueDateRequest $request)
    {
        $response = $this->service->getByDueDate($request);
        return $this->response($response);
    }

    public function  generateByDueDate(generateTodayDueDateRequest $request)
    {
        $batch_no = $this->service->generateByDueDate($request);
        return $this->response($batch_no);
    }
}
