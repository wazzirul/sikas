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
        Schema::create('anggota', function (Blueprint $table) {
            $table->increments('id_anggota');
            $table->smallInteger('tipe_anggota');
            $table->string('nama');
            $table->string('nis')->nullable();
            $table->string('nip')->nullable();
            $table->unsignedInteger('id_kelas')->nullable();
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
            $table->unsignedInteger('id_jurusan')->nullable();
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan');
            $table->integer('nomor_kelas')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('angkatan')->nullable();
            $table->smallInteger('alumni')->default(0);

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
        Schema::dropIfExists('anggota');
    }
};
