<?php


namespace App\Services;


use App\Repositories\AutoDebetRepository;
use App\Traits\paginatorTrait;
use Illuminate\Support\Facades\Storage;

class AutoDebetService
{
    use paginatorTrait;

    protected $repository;

    public function __construct(
        AutoDebetRepository $repository
    )
    {
        $this->repository = $repository;
    }

    public function insertAutoDebet($data,$auto_debet_type)
    {
        foreach($data as $d) {
            $auto_debet = array(
                "no_rek"                    => $d->norek,
                "no_pin"                    => $d->nopin,
                "cust_name"                 => $d->custname,
                "account_no"                => $d->accountno,
                "installment"               => $d->installment,
                "police_no"                 => $d->policeno,
                "periode_ke"                => $d->periodeke,
                "tgl_jatuh_tempo"           => $d->tgljatuhtempo,
                "tgl_awal_create_text_file" => $d->tglawalcreatetextfile,
                "tgl_akhir_create_text_file"=> $d->tglakhircreatetextfile,
                "free_field_1"              => $d->freefield1,
                "free_field_2"              => $d->freefield2,
                "free_field_3"              => $d->freefield3,
                "atas_nama_bank"            => $d->atasnamabank,
                "jf_due_date"               => $d->jfduedate,
                "jumlah_tunggakan"          => $d->jumlahtunggakan,
                "packet_name"               => $d->packetname,
                "kode_bank"                 => $d->kodebank,
                "no_rek_bank"               => $d->norekbank,
                "bank"                      => $d->bank,
                "sts"                       => "0",
                "auto_debet_type"           => $auto_debet_type
            );

            $this->repository->firstOrCreate($auto_debet);
        }
    }
}
