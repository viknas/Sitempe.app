<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\District::factory(10)->create();
        \App\Models\Regency::factory(10)->create();
        \App\Models\User::factory(10)->create();

        User::create([
            'nama' => 'Super Admin',
            'email' => 'admin@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'id_kecamatan' => 1,
            'id_kabupaten' => 2,
            'role' => 'OWNER'
        ]);

        Product::create([
            'nama_produk' => 'testing',
            'harga' => 1000,
            'deskripsi' => 'sdafdsagda dasd',
            'stok' => 20,
            'foto_produk' => 'tstse'
        ]);
    }
}
