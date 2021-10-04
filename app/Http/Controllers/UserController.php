<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Traits\responseTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use responseTrait;

    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $response = $this->service->pagination($request);
        return $this->response($response, 'List User successfully retrieved', 'User retrieved');
    }

    public function detail($id)
    {
        $response = $this->service->getById($id);
        return $this->response($response, 'User Detail successfully retrieved', 'User retrieved');
    }

    public function update($id, UpdateRequest $request)
    {
        $response = $this->service->update($id, $request);
        return $this->response($response, 'User successfully updated', 'User updated');
    }

    public function create(CreateRequest $request)
    {
        $response = $this->service->create($request);
        return $this->response($response, 'User successfully created', 'User created');
    }

    public function delete($id)
    {
        $response = $this->service->delete($id);
        return $this->response($response, 'User successfully deleted', 'User deleted');
    }

    public function toggleStatus($id)
    {
        $response = $this->service->toggle($id);
        if ( $response->sts === true){
            return $this->response($response, 'User successfully activate', 'User updated');
        }
        return $this->response($response, 'User successfully deactivate', 'User updated');
    }
}
