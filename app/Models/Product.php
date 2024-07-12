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

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'product_id');
    }

    public function getAvgRatingAttribute()
    {
        $rating = $this->rating()->get();
        $count = count($rating);
        $sum = $rating->sum('rating');
        if ($count > 0) {
            return round($sum / $count, 1, PHP_ROUND_HALF_UP);
        }
        return 0;
    }

    public function getTerjualAttribute()
    {
        return count($this->keranjang()->whereNotNull('penjualan_id')->get());
    }

}
