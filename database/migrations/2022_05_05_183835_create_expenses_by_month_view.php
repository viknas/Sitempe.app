<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement('DROP VIEW IF EXISTS expenses_by_month_view;');
        DB::statement(
            "CREATE VIEW expenses_by_month_view
            AS
            SELECT
                DATE_FORMAT(tanggal, '%Y-%m') AS tanggal,
                SUM(data_pengeluaran.jumlah_pengeluaran) AS total_pengeluaran
            FROM
                data_pengeluaran
            GROUP BY
                DATE_FORMAT(tanggal, '%Y-%m');");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses_by_month_view');
    }
};
