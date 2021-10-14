<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\CreateRequest;
use App\Http\Requests\Group\UpdateRequest;
use App\Services\GroupService;
use App\Traits\responseTrait;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    use responseTrait;

    protected $service;

    public function __construct(GroupService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $response = $this->service->pagination($request);
        return $this->response($response);
    }

    public function detail($id)
    {
        $response = $this->service->getById($id);
        return $this->response($response);
    }

    public function update($id, UpdateRequest $request)
    {
        $response = $this->service->update($id, $request);
        return $this->response($response);
    }

    public function create(CreateRequest $request)
    {
        $response = $this->service->create($request);
        return $this->response($response);
    }

    public function delete($id)
    {
        $response = $this->service->delete($id);
        return $this->response($response);
    }
}
