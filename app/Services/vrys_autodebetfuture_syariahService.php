<?php


namespace App\Services;

use App\Repositories\AutoDebetRepository;
use App\Repositories\vrys_autodebetfuture_syariahRepository;
use App\Traits\paginatorTrait;

class vrys_autodebetfuture_syariahService
{
    use paginatorTrait;

    protected $repository;
    protected $generateTextfileService;
    protected $autoDebetRepository;

    public function __construct(
        vrys_autodebetfuture_syariahRepository $repository,
        GenerateTextfileService $generateTextfileService,
        AutoDebetService $autoDebetService,
        AutoDebetRepository $autoDebetRepository
    )
    {
        $this->repository = $repository;
        $this->generateTextfileService = $generateTextfileService;
        $this->autoDebetService = $autoDebetService;
        $this->autoDebetRepository = $autoDebetRepository;
    }

    public function importAutoDebet($request)
    {
        $unique = $this->repository->import($request['date']);
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

    public function getByDueDate($request)
    {
        $data = $this->repository->getByDueDate($request->date);
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
        $data = $this->autoDebetRepository->getFuture($request->date);
        $file_name = $this->generateTextfileService->createTextfile($data,'future',$request->user()->id);
        return $file_name;
    }
}
