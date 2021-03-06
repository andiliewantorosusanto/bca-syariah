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
        $delay = env('DB_DELAY');
        $loop = env('DB_LOOP');
        $time = $delay * $loop;

        while($loop != 0)
        {
            $done = $this->repository->checkJobs($unique);

            if($done) {
                return [
                    'data' => $unique,
                    'message' => 'import berhasil'
                ];
            }
            $loop--;
            sleep($delay);
        }

        return [
            'data' => false,
            'message' => 'import belum selesai setelah '.$time.' detik. Mohon Kontak Administrator dengan kode : '. $unique
        ];
    }

    public function getByDueDate($request)
    {
        $data = $this->repository->getByDueDate($request->date);
        return $data;
    }

    public function generateByDueDate($request)
    {
        $data = $this->autoDebetRepository->getFuture($request->token);
        $file_name = $this->generateTextfileService->createTextfile($data,'future',$request->user()->id);
        return $file_name;
    }
}
