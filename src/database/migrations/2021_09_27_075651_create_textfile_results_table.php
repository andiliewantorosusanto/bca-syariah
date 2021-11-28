<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextfileResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('textfile_results', function (Blueprint $table) {
            $table->id();
            $table->string('batch_no');
            $table->string('nomor_rekening');
            $table->string('jenis_mutasi');
            $table->string('trx_code');
            $table->decimal('amount',25,2);
            $table->string('sign');
            $table->string('deskripsi');
            $table->string('status_va');
            $table->string('ket_validasi')->nullable(true);
            $table->string('sts_proses')->nullable(true);
            $table->string('ket_proses');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
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
        Schema::dropIfExists('textfile_results');
    }
}
