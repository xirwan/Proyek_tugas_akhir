<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug'
    ];

    // Menghasilkan slug secara otomatis
    public static function boot()
    {
        parent::boot();

        static::creating(function ($newscategory) {
            if (empty($newscategory->slug)) {
                $newscategory->slug = Str::slug($newscategory->name);
            }

            // Cek jika slug sudah ada, tambahkan angka untuk menghindari duplikasi
            if (NewsCategory::where('slug', $newscategory->slug)->exists()) {
                $newscategory->slug = $newscategory->slug . '-' . rand(1, 1000); // Menambahkan angka acak
            }
        });
    }


    // Relasi dengan berita
    public function news()
    {
        return $this->hasMany(News::class);
    }
}
