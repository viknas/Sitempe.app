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
        Schema::create('penjualan_produk', function (Blueprint $table) {
            $table->id();
            $table->string('code', 6)->nullable();
            $table->date('tanggal');
            $table->unsignedInteger('jumlah_produk')->default(0);
            $table->unsignedInteger('total_harga')->default(0);
            $table->enum('tipe', ['LANGSUNG', 'DIPESAN']);
            $table->enum('status', ['MENUNGGU KONFIRMASI', 'SELESAI', 'DIBATALKAN',null])->default(null)->nullable();
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
