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
        Schema::table('detail_permintaan_produk', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->foreignId('id_produk')->constrained('produk')->cascadeOnUpdate()->restrictOnDelete();
                $table->foreignId('id_permintaan')->constrained('permintaan_produk')->cascadeOnUpdate()->cascadeOnDelete();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_permintaan_produk', function (Blueprint $table) {
            //
        });
    }
};
