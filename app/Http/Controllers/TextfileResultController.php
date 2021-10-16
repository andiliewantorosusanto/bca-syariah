<?php

namespace App\Http\Controllers;

use App\Services\TextfileResultService;
use App\Traits\responseTrait;
use Illuminate\Http\Request;


class TextfileResultController extends Controller
{
    use responseTrait;

    protected $service;

    public function __construct(TextfileResultService $service)
    {
        $this->service = $service;
    }

    public function import(Request $request)
    {
        $response = $this->service->import($request);
        return $this->response($response);
    }

    public function index(Request $request)
    {
        $response = $this->service->pagination($request);
        return $this->response($response);
    }
}
