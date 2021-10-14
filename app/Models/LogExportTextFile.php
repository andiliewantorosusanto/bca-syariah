<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogExportTextfile extends Model
{
    use HasFactory;
    protected $fillable = [
        "batch_no",
        "file_path",
        "file_name",
        'created_by',
    ];
}
