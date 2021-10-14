<?php

namespace App\Http\Controllers;

use App\Services\LogTextfileResultService;
use App\Traits\responseTrait;
use Illuminate\Http\Request;

class LogTextfileResultController extends Controller
{
    use responseTrait;

    protected $service;

    public function __construct(LogTextfileResultService $service)
    {
        $this->service = $service;
    }

    public function browse(Request $request)
    {
        $response = $this->service->browse($request);
        return $this->response($response);
    }
}
