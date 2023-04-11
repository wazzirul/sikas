<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabungan_umum', function (Blueprint $table) {
            $table->increments('id_tabungan_umum');
            $table->string('nomor_tabungan')->unique();
            $table->string('nama_tabungan');
            $table->bigInteger('tabungan')->default(0);
            $table->string('keterangan')->nullable();

            $table->smallInteger('soft_delete')->default(0);
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
        Schema::dropIfExists('tabungan_umum');
    }
};
