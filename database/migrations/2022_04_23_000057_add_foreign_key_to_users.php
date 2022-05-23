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
        Schema::table('users', function (Blueprint $table) {
            $table->after('id', function ($table) {
                $table->foreign('regency_id')
                    ->references('id')
                    ->on('regencies')
                    ->onUpdate('cascade')->onDelete('restrict');

                $table->foreign('district_id')
                    ->references('id')
                    ->on('districts')
                    ->onUpdate('cascade')->onDelete('restrict');
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
