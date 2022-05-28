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

    public function saleDetail()
    {
        return $this->hasMany(SaleDetail::class, 'id_produk')
            ->whereHas('sale', function ($query) {
                return $query
                    ->where('tipe', '=', 'LANGSUNG')
                    ->orWhere('status', '=', 'SELESAI');
            });
    }

    public function soldPerMonth()
    {

        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
        return $this->saleDetail()->whereHas('sale', function ($query) use ($startOfMonth, $endOfMonth) {
                return $query->whereBetween('tanggal', [$startOfMonth, $endOfMonth]);
            })->sum('jumlah_produk');
    }
}
