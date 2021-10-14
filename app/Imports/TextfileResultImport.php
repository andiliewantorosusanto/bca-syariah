<?php

namespace App\Imports;

use App\Models\TextfileResult;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TextfileResultImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $batch_no,$user_id;

    public function __construct($batch_no,$user_id)
    {
        $this->batch_no = $batch_no;
        $this->user_id = $user_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new TextfileResult([
            'batch_no'              => $this->batch_no,
            'nomor_rekening'        => $row['nomor_rekening'],
            'jenis_mutasi'          => $row['jenis_mutasi'],
            'trx_code'              => $row['trx_code'],
            'amount'                => $row['amount'],
            'sign'                  => $row['sign'],
            'deskripsi'             => $row['deskripsi'],
            'status_va'             => $row['status_va'],
            'ket_validasi'          => $row['ket_validasi'],
            'sts_proses'            => $row['status_proses'],
            'ket_proses'            => $row['ket_proses'],
            'updated_by'            => $this->user_id,
            'created_by'            => $this->user_id
        ]);
    }

    public function rules(): array
    {
        return [
            'nomor_rekening'    => 'required|digits_between:1,20',
            'jenis_mutasi'      => ['required',Rule::in(['C','D'])],
            'trx_code'          => ['required',Rule::in(['4011','4012'])],
            'amount'            => 'required|digits_between:1,25',
            'sign'              => ['required',Rule::in(['+','-'])],
            'deskripsi'         => 'required|max:50',
            'status_va'         => 'required|alpha|max:10',
            'ket_validasi'      => 'max:50',
            'status_proses'     => 'alpha_num|max:10',
            'ket_proses'        => 'required|max:50'
        ];
    }
}
