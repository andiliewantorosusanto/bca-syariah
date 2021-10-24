<?php


namespace App\Services;

use App\Repositories\AutoDebetRepository;
use App\Repositories\vrys_autodebetkonsumenbermasalah_syariahRepository;
use App\Traits\paginatorTrait;

class vrys_autodebetkonsumenbermasalah_syariahService
{
    use paginatorTrait;

    protected $repository;
    protected $generateTextfileService;
    protected $autoDebetRepository;


    public function __construct(vrys_autodebetkonsumenbermasalah_syariahRepository $repository,
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
        $unique = $this->repository->import();
        $delay = 5;
        $loop = 12;
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

    public function getTodayDueDate()
    {
        $data = $this->repository->getTodayDueDate();
        return $data;
    }

    public function generateTodayDueDate($request)
    {
        $data = $this->autoDebetRepository->getKonsumenBermasalah($request->token);
        $file_name = $this->generateTextfileService->createTextfile($data,'overdue',$request->user()->id);
        return $file_name;
    }
}
