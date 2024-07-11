<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_id',
        'nama',
        'harga',
        'qty',
        'deskripsi',
        'gambar'
    ];

    public function category()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class, 'product_id');
    }
}
