<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $table = 'detail_penjualan';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $touches = ['sale'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'id_penjualan');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function (SaleDetail $item) {
            $product = $item->product;
            $product->stok = $product->stok - $item->jumlah_produk;
            $product->save();
        });

        static::saved(function (SaleDetail $item) {
            if (!$item->wasRecentlyCreated) {
                $product = $item->product;
                $product->stok = ($product->stok + $item->getOriginal('jumlah_produk')) - $item->jumlah_produk;
                $product->save();
            }
        });
    }
}
