<?php

namespace App\Http\Controllers;

use App\Services\LogTextfileResultService;
use App\Traits\responseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogTextfileResultController extends Controller
{
    use responseTrait;

    protected $service;

    public function __construct(LogTextfileResultService $service)
    {
        $this->service = $service;
    }

    public function browse(Request $request)
    {
        $response = $this->service->browse($request);
        return $this->response($response);
    }

    public function downloadTextfile(Request $request)
    {
        $log_export_textfile = $this->service->getByBatchNoAndStatusExport($request->batch_no,false);
        if($log_export_textfile) {
            $this->service->updateStatusExporeByBatchNo($request->batch_no);
            return Storage::disk('local')->download($log_export_textfile->file_path_textfile,$log_export_textfile->file_name_textfile,array('Access-Control-Expose-Headers' => "Content-Disposition"));
        }
        else {
            return $this->response(false,"Textfile already exported",422);
        }
    }

    public function downloadExcel(Request $request)
    {
        $log_export_textfile = $this->service->getByBatchNo($request->batch_no);
        return Storage::disk('local')->download($log_export_textfile->file_path_excel,$log_export_textfile->file_name_excel,array('Access-Control-Expose-Headers' => "Content-Disposition"));
    }
}
