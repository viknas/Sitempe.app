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
}
