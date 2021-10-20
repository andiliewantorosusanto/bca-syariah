<?php

namespace App\Http\Controllers;

use App\Models\AutoDebet;
use App\Services\AutoDebetService;
use App\Traits\responseTrait;
use Illuminate\Http\Request;

class AutoDebetController extends Controller
{
    use responseTrait;

    protected $service;

    public function __construct(AutoDebetService $service)
    {
        $this->service = $service;
    }

    public function getFuture(Request $request)
    {
        $response = $this->service->getFuture($request);
        return $this->response($response);
    }

    public function getKonsumenBermasalah(Request $request)
    {
        $response = $this->service->getKonsumenBermasalah($request);
        return $this->response($response);
    }

    public function getNormal(Request $request)
    {
        $response = $this->service->getNormal($request);
        return $this->response($response);
    }
}
