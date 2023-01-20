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
        Schema::create('keuangan_anggota', function (Blueprint $table) {
            $table->increments('id_keuangan_anggota');
            $table->unsignedInteger('id_anggota');
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota');
            $table->bigInteger('tabungan')->default(0);
            $table->bigInteger('tagihan')->default(0);
            $table->bigInteger('tagihan_pertama')->default(0);
            $table->smallInteger('status_tagihan')->default(0);

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
        Schema::dropIfExists('keuangan_anggota');
    }
};
