<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTextfileResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path_textfile',
        'file_name_textfile',
        'file_path_excel',
        'file_name_excel',
        'batch_no',
        'status_export',
        'created_at',
        'updated_at'
    ];

    public function textfileresults()
    {
        return $this->hasMany(TextfileResult::class,'batch_no','batch_no');
    }

    public function updatedby()
    {
        return $this->hasOne(User::class,'id','updated_by');
    }
}
