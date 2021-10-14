<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextfileResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_no',
        'nomor_rekening',
        'jenis_mutasi',
        'trx_code',
        'amount',
        'sign',
        'deskripsi',
        'status_va',
        'ket_validasi',
        'sts_proses',
        'ket_proses',
        'created_by',
        'updated_by'
    ];
}
