<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'penjualan_produk';
    protected $guarded = ['id'];
    protected $appends = ['total_harga', 'total_produk'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class, 'id_penjualan');
    }

    public function getTotalProdukAttribute()
    {
        return $this->details->sum('jumlah_produk');
    }

    public function getTotalHargaAttribute()
    {
        return $this->details()->sum(DB::raw('detail_penjualan.harga * detail_penjualan.jumlah_produk'));
    }
}
