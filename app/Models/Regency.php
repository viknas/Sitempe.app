<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    use HasFactory;

    protected $table = 'kabupaten';
    protected $guarded = ['id'];
    public $timestamps = false;
}
