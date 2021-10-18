<?php

namespace App\Http\Controllers;

use App\Services\LogExportTextfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\responseTrait;

class LogExportTextfileController extends Controller
{
    use responseTrait;

    protected $service;

    public function __construct(LogExportTextfileService $service)
    {
        $this->service = $service;
    }

    public function downloadTextfile(Request $request)
    {
        $log_export_textfile = $this->service->getByBatchNo($request->batch_no);
        return Storage::disk('local')->download($log_export_textfile->file_path,$log_export_textfile->file_name,array('Access-Control-Expose-Headers' => "Content-Disposition"));
    }
}
