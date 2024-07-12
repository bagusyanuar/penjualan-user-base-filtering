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

    //status note
    // 0 menunggu pembayaran
    // 1 menunggu konfirmasi pembayaran
    // 2 pembayaran di tolak
    // 3 barang di packing
    // 4 barang siap di ambil
    // 5 barang di kirim
    // 6 selesai
    protected $casts = [
        'is_kirim' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class,'penjualan_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'penjualan_id');
    }

    public function pembayaran_status()
    {
        return $this->hasOne(Pembayaran::class, 'penjualan_id')->orderBy('created_at', 'DESC');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class,'penjualan_id');
    }
}
