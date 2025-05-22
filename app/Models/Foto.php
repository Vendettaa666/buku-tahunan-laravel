<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $fillable = [
        'buku_id',
        'judul',
        'foto_path',
        'deskripsi'
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
