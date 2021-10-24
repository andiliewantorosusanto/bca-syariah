<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoDebetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('othercsf')->create('auto_debets', function (Blueprint $table) {
            $table->id();
            $table->string('no_rek');
            $table->string('no_pin');
            $table->string('cust_name');
            $table->string('account_no');
            $table->decimal('installment',25,2);
            $table->string('police_no');
            $table->integer('periode_ke');
            $table->dateTime('tgl_jatuh_tempo');
            $table->dateTime('tgl_awal_create_text_file')->nullable(true);
            $table->dateTime('tgl_akhir_create_text_file')->nullable(true);
            $table->string('free_field_1');
            $table->string('free_field_2');
            $table->string('free_field_3');
            $table->string('atas_nama_bank');
            $table->dateTime('jf_due_date')->nullable(true);
            $table->integer('jumlah_tunggakan');
            $table->string('packet_name');
            $table->string('kode_bank');
            $table->string('no_rek_bank');
            $table->string('bank');
            $table->boolean('sts');
            $table->string('auto_debet_type');
            $table->string('token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_debets');
    }
}
