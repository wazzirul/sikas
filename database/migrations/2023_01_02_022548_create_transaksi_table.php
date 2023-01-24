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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments('id_transaksi');
            $table->unsignedInteger('id_admin');
            $table->foreign('id_admin')->references('id_user')->on('user');
            $table->string('nomor_transaksi');
            $table->string('kode_transaksi');
            $table->unsignedInteger('id_anggota')->nullable();
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota');
            $table->smallInteger('tipe_transaksi');
            $table->string('nama_transaksi')->nullable();
            $table->unsignedInteger('id_tagihan')->nullable();
            $table->foreign('id_tagihan')->references('id_tagihan')->on('tagihan');
            $table->bigInteger('jumlah');
            $table->bigInteger('mutasi')->nullable();
            $table->unsignedInteger('id_kelas')->nullable();
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
            $table->smallInteger('approved')->default(1);
            $table->timestamp('tanggal')->useCurrent();

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
        Schema::dropIfExists('transaksi');
    }
};
