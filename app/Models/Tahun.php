<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }
}
