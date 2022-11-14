<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbMasalahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_masalah', function (Blueprint $table) {
            $table->uuid('id_masalah',50);
            $table->dateTime('tanggal_ditemukan');
            $table->integer('informer',15);
            $table->foreign('informer')->references('id')->on('tb_user');
            $table->char('no_kartu',11);
            $table->char('klasifikasi',15);
            $table->char('lokasi',25);
            $table->char('masalah',255);
            $table->char('penyebab',255)->nullable();
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
        Schema::dropIfExists('tb_masalah');
    }
}
