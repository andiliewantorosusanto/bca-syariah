<?php

namespace App\Http\Controllers;

use App\Services\vrys_autodebetkonsumenbermasalah_syariahService;
use App\Traits\responseTrait;
use Illuminate\Http\Request;

class vrys_autodebetkonsumenbermasalah_syariahController extends Controller
{
    use responseTrait;

    protected $service;

    public function __construct(vrys_autodebetkonsumenbermasalah_syariahService $service)
    {
        $this->service = $service;
    }

    public function getTodayDueDate(Request $request)
    {
        $response = $this->service->getTodayDueDate($request);
        return $this->response($response);
    }

    public function  generateTodayDueDate(Request $request)
    {
        $response = $this->service->generateTodayDueDate($request);
        return $this->response($response);
    }
}
