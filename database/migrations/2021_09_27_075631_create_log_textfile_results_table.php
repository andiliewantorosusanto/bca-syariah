<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTextfileResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_textfile_results', function (Blueprint $table) {
            $table->id();
            $table->string('file_path_text_file');
            $table->string('file_name_text_file');
            $table->string('file_path_excel');
            $table->string('file_name_excel');
            $table->string('batch_no');
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
        Schema::dropIfExists('log_textfile_results');
    }
}
