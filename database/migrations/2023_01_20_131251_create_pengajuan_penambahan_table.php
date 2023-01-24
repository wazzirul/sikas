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
        Schema::create('pengajuan_penambahan', function (Blueprint $table) {
            $table->increments('id_pengajuan_penambahan');
            $table->unsignedInteger('id_admin')->nullable();
            $table->foreign('id_admin')->references('id_user')->on('user');
            $table->unsignedInteger('id_anggota');
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota');
            $table->bigInteger('jumlah');
            $table->string('file')->nullable();
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
        Schema::dropIfExists('pengajuan_penambahan');
    }
};
