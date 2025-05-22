<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_id',
        'kategori_id',
        'nama_kelas',
        'penerbit',
        'cover_path',
        'file_path'
    ];

    public function tahun()
    {
        return $this->belongsTo(Tahun::class);
    }

    public function kategori()
{
    return $this->belongsTo(Kategori::class);
}
}
