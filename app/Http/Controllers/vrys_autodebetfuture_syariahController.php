<?php

namespace App\Http\Controllers;

use App\Services\vrys_autodebetfuture_syariahService;
use App\Traits\responseTrait;
use Illuminate\Http\Request;

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

    public function getByDueDate(Request $request)
    {
        $response = $this->service->getByDueDate($request);
        return $this->response($response);
    }

    public function  generateByDueDate(Request $request)
    {
        $batch_no = $this->service->generateByDueDate($request);
        return $this->response($batch_no);
    }

}
