<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuTypeController extends Controller
{
    use responseTrait;

    protected $service;

    public function __construct(MenuTypeService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $response = $this->service->pagination($request);
        return $this->response($response, 'List Generate Textfile successfully retrieved', 'Generate Textfile retrieved');
    }

    public function detail($id)
    {
        $response = $this->service->getById($id);
        return $this->response($response, 'Generate Textfile Detail successfully retrieved', 'Generate Textfile retrieved');
    }

    public function update($id, UpdateRequest $request)
    {
        $response = $this->service->update($id, $request);
        return $this->response($response, 'Generate Textfile successfully updated', 'Generate Textfile updated');
    }

    public function create(CreateRequest $request)
    {
        $response = $this->service->create($request);
        return $this->response($response, 'Generate Textfile successfully created', 'Generate Textfile created');
    }

    public function delete($id)
    {
        $response = $this->service->delete($id);
        return $this->response($response, 'Generate Textfile successfully deleted', 'Generate Textfile deleted');
    }
}
