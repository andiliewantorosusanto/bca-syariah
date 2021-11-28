<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoDebet extends Model
{
    use HasFactory;
    protected $connection= 'othercsf';

    protected $fillable = [
        "no_rek",
        "no_pin",
        "cust_name",
        "account_no",
        "installment",
        "police_no",
        "periode_ke",
        "tgl_jatuh_tempo",
        "tgl_awal_create_text_file",
        "tgl_akhir_create_text_file",
        "free_field_1",
        "free_field_2",
        "free_field_3",
        "atas_nama_bank",
        "jf_due_date",
        "jumlah_tunggakan",
        "packet_name",
        "kode_bank",
        "no_rek_bank",
        "bank",
        "sts",
        "auto_debet_type"
    ];
}
