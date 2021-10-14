<?php


namespace App\Services;


use App\Repositories\vrys_autodebetkonsumenbermasalah_syariahRepository;
use App\Traits\paginatorTrait;

class vrys_autodebetkonsumenbermasalah_syariahService
{
    use paginatorTrait;

    protected $repository;
    protected $generateTextfileService;

    public function __construct(vrys_autodebetkonsumenbermasalah_syariahRepository $repository,
        GenerateTextfileService $generateTextfileService)
    {
        $this->repository = $repository;
        $this->generateTextfileService = $generateTextfileService;
    }

    public function getTodayDueDate()
    {
        $data = $this->repository->getTodayDueDate();
        $totalData = count($data);
        $totalAmount = $data->sum('installment');

        return [
            'totalData' => $totalData,
            'totalAmount' => $totalAmount,
            'data' => $data
        ];
    }

    public function generateTodayDueDate($request)
    {
        $data = $this->repository->getTodayDueDate();
        $file_name = $this->generateTextfileService->createTextfile($data,'overdue',$request->user()->id);
        return $file_name;
    }
}
