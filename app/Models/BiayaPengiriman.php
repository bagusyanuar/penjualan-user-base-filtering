<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaPengiriman extends Model
{
    use HasFactory;

    protected $table = 'biaya_pengirimans';

    protected $fillable = [
        'kota',
        'harga'
    ];
}
