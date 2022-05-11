<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'produk';
    protected $guarded = ['id'];
    protected $appends = ['total_terjual'];

    public function sale()
    {
        return $this->hasManyThrough(Sale::class, SaleDetail::class, 'id_produk', 'id', 'id', 'id_penjualan')
            ->where('tipe', '=', 'LANGSUNG')
            ->orWhere('status', '=', 'SELESAI');
    }

    public function getTotalTerjualAttribute()
    {

        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
        return $this->sale
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->sum('total_produk');
    }
}
