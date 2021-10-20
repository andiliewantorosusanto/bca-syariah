<?php


namespace App\Services;

use App\Repositories\AutoDebetRepository;
use App\Repositories\vrys_autodebetnormal_syariahRepository;
use App\Traits\paginatorTrait;

class vrys_autodebetnormal_syariahService
{
    use paginatorTrait;

    protected $repository;
    protected $generateTextfileService;
    protected $autoDebetRepository;

    public function __construct(vrys_autodebetnormal_syariahRepository $repository,
    GenerateTextfileService $generateTextfileService,
    AutoDebetService $autoDebetService,
    AutoDebetRepository $autoDebetRepository)
    {
        $this->repository = $repository;
        $this->generateTextfileService = $generateTextfileService;
        $this->autoDebetService = $autoDebetService;
        $this->autoDebetRepository = $autoDebetRepository;
    }

    public function importAutoDebet($request)
    {
        $unique = $this->repository->import();
        $delay = 5;
        $loop = 12;
        $time = $delay * $loop;

        while($loop != 0)
        {
            $data = $this->repository->checkJobs($unique);
            if($data) {
                return [
                    'data' => true,
                    'message' => 'import berhasil'
                ];
            }
            $loop--;
            sleep($delay);
        }

        return [
            'data' => false,
            'message' => 'import belum selesai setelah '.$time.' detik'
        ];
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
        $data = $this->autoDebetRepository->getNormal();
        $file_name = $this->generateTextfileService->createTextfile($data,'normal',$request->user()->id);
        return $file_name;
    }
}
