<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Tahun extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'cover_image'
    ];

    protected $appends = ['cover_image_url'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }

    public function getCoverImageUrlAttribute()
    {
        if (!$this->cover_image) {
            return null;
        }
        return asset('storage/cover_years/' . $this->cover_image);
    }

    // Menghapus accessor lama yang konflik
    // public function getCoverImageAttribute($value)
    // {
    //     if (!$value) return null;
    //     return Storage::url('cover_years/' . $value);
    // }
}
