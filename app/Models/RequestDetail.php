<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestDetail extends Model
{
    use HasFactory;

    protected $table = 'detail_permintaan_produk';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }

    public function request()
    {
        return $this->belongsTo(Request::class, 'id_permintaan');
    }
}
