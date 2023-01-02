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
        Schema::create('keuangan_sekolah', function (Blueprint $table) {
            $table->increments('id_keuangan_sekolah');
            $table->bigInteger('total')->default(0);
            $table->bigInteger('pemasukan')->default(0);
            $table->bigInteger('pengeluaran')->default(0);

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
        Schema::dropIfExists('keuangan_sekolah');
    }
};
