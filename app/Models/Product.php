<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'produk';
    protected $guarded = ['id'];
    protected $appends = ['total_terjual'];

    public function sale()
    {
        return $this->hasManyThrough(Sale::class, SaleDetail::class, 'id_produk', 'id')
            ->where('tipe', '=', 'LANGSUNG')
            ->orWhere('status', '=', 'SELESAI');
    }

    public function getTotalTerjualAttribute()
    {
        return $this->sale
            ->sum('total_produk');
    }
}
