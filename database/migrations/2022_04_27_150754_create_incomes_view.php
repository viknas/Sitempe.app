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
        DB::statement('DROP VIEW IF EXISTS incomes_view;');

        DB::statement(
            "CREATE VIEW incomes_view
            AS
            SELECT
                penjualan_produk.id AS id,
                penjualan_produk.tanggal AS tanggal,
                SUM(detail_penjualan.jumlah_produk) AS total_produk,
                SUM(
                    detail_penjualan.harga * detail_penjualan.jumlah_produk
                ) AS total_harga,
                penjualan_produk.created_at AS created_at,
                penjualan_produk.updated_at AS updated_at
            FROM
                penjualan_produk
            LEFT JOIN detail_penjualan ON penjualan_produk.id = detail_penjualan.id_penjualan
            WHERE
                penjualan_produk.status = 'DIKONFIRMASI' OR penjualan_produk.tipe = 'LANGSUNG'
            GROUP BY
                penjualan_produk.id;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS incomes_view;');
    }
};
