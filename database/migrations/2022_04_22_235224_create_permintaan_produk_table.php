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
        Schema::create('permintaan_produk', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('status', ['MENUNGGU KONFIRMASI', 'DIKONFIRMASI', 'SELESAI']);
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
        Schema::dropIfExists('permintaan_produk');
    }
};
