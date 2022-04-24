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
        Schema::table('data_pendapatan', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->foreignId('id_user')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
                $table->foreignId('id_permintaan')->constrained('permintaan_produk')->cascadeOnUpdate()->restrictOnDelete();
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
        Schema::table('data_pendapatan', function (Blueprint $table) {
            //
        });
    }
};
