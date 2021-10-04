<?php

namespace App\Http\Controllers;

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
        return $this->response($response, 'List Group successfully retrieved', 'Group retrieved');
    }

    public function detail($id)
    {
        $response = $this->service->getById($id);
        return $this->response($response, 'Group Detail successfully retrieved', 'Group retrieved');
    }

    public function update($id, UpdateRequest $request)
    {
        $response = $this->service->update($id, $request);
        return $this->response($response, 'Group successfully updated', 'Group updated');
    }

    public function create(CreateRequest $request)
    {
        $response = $this->service->create($request);
        return $this->response($response, 'Group successfully created', 'Group created');
    }

    public function delete($id)
    {
        $response = $this->service->delete($id);
        return $this->response($response, 'Group successfully deleted', 'Group deleted');
    }
}
