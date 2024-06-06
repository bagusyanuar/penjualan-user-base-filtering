<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';

    protected $fillable = [
        'user_id',
        'tanggal',
        'no_penjualan',
        'sub_total',
        'ongkir',
        'total',
        'status',
        'is_kirim',
        'kota',
        'alamat'
    ];
}
