<?php


namespace App\Services;

use App\Repositories\vrys_autodebetfuture_syariahRepository;
use App\Traits\paginatorTrait;

class vrys_autodebetfuture_syariahService
{
    use paginatorTrait;

    protected $repository;
    protected $generateTextfileService;

    public function __construct(
        vrys_autodebetfuture_syariahRepository $repository,
        GenerateTextfileService $generateTextfileService
    )
    {
        $this->repository = $repository;
        $this->generateTextfileService = $generateTextfileService;
    }

    public function getByDueDate($request)
    {
        $data = $this->repository->getByDueDate($request->due_date);
        $totalData = count($data);
        $totalAmount = $data->sum('installment');

        return [
            'totalData' => $totalData,
            'totalAmount' => $totalAmount,
            'data' => $data
        ];
    }

    public function generateByDueDate($request)
    {
        $data = $this->repository->getByDueDate($request->due_date);
        $file_name = $this->generateTextfileService->createTextfile($data,'future',$request->user()->id);
        return $file_name;
    }
}
