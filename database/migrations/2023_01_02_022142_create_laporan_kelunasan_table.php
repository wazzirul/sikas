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
        Schema::create('laporan_kelunasan', function (Blueprint $table) {
            $table->increments('id_laporan_kelunasan');
            $table->unsignedInteger('id_anggota');
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota');
            $table->timestamp('tanggal')->useCurrent();
            $table->unsignedInteger('id_kelas');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');

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
        Schema::dropIfExists('laporan_kelunasan');
    }
};
