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
        Schema::create('history_tagihan_bulanan', function (Blueprint $table) {
            $table->increments('id_history_tagihan');
            $table->unsignedInteger('id_anggota');
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota');
            $table->unsignedInteger('id_tagihan');
            $table->foreign('id_tagihan')->references('id_tagihan')->on('tagihan');
            $table->integer('prefix_tagihan')->nullable();
            $table->string('bulan')->nullable();
            $table->string('tahun_ajaran')->nullable();
            $table->bigInteger('jumlah');
            $table->integer('status')->default(0);

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
        Schema::dropIfExists('history_tagihan_bulanan');
    }
};
