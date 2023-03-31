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
        Schema::create('bridge_history_bulan', function (Blueprint $table) {
            $table->increments('id_bridge_history_bulan');
            $table->unsignedInteger('id_transaksi');
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi');
            $table->unsignedInteger('id_history_tagihan');
            $table->foreign('id_history_tagihan')->references('id_history_tagihan')->on('history_tagihan_bulanan');

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
        Schema::dropIfExists('bridge_history_bulan');
    }
};
