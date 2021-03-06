<?php

namespace App\Models;

use App\Models\CSF\CorAccount;
use App\Models\CSF\CorAccountInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Awobaz\Compoships\Compoships;

class TextfileResult extends Model
{
    use HasFactory,Compoships;

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
        'updated_by',
        'no_rek',
        'no_pin'
    ];

    public function corAccount()
    {
        return $this->hasOne(CorAccount::class,['NoRek','NoPin'],['no_rek','no_pin']);
    }

    public function corAccountInfo()
    {
        return $this->hasOne(CorAccountInfo::class,['NoRek','NoPin'],['no_rek','no_pin']);
    }
}
