<?php

namespace App\Imports;

use App\Models\TextfileResult;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;

class TextfileResultImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $batch_no,$user_id;

    public function __construct($batch_no,$user_id)
    {
        $this->batch_no = $batch_no;
        $this->user_id = $user_id;
    }

    /**
     * @return int
     */
    public function headingRow(): int
    {
        return 2;
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
            'jenis_mutasi'          => $row['jns_mutasi'],
            'trx_code'              => $row['trx_code'],
            'amount'                => $row['amount'],
            'sign'                  => $row['sign'],
            'deskripsi'             => $row['deskripsi'],
            'status_va'             => $row['status_validasi_sbl_otor'],
            'ket_validasi'          => $row['ket_validasi_sbl_otor'],
            'sts_proses'            => $row['status_proses_stl_otor'],
            'ket_proses'            => $row['ket_proses_stl_otor'],
            'no_rek'                => explode("-",$row['deskripsi'])[0],
            'no_pin'                => explode("-",$row['deskripsi'])[1],
            'updated_by'            => $this->user_id,
            'created_by'            => $this->user_id
        ]);
    }

    public function rules(): array
    {
        return [
            'nomor_rekening'                   => 'required|digits_between:1,20',
            'jns_mutasi'                       => ['required',Rule::in(['C','D'])],
            'trx_code'                         => ['required',Rule::in(['4011','4012'])],
            'amount'                           => 'required|digits_between:1,25',
            'sign'                             => ['required',Rule::in(['+','-'])],
            'deskripsi'                        => 'required|max:50',
            'status_validasi_sbl_otor'         => 'required|max:10',
            'ket_validasi_sbl_otor'            => 'max:50',
            'status_proses_stl_otor'           => 'alpha_num|max:10',
            'ket_proses_stl_otor'              => 'required|max:50'
        ];
    }
}
