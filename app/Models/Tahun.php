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

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }

    public function getCoverImageAttribute($value)
{
    if (!$value) return null;
    return Storage::url('cover_years/' . $value);
}
}
