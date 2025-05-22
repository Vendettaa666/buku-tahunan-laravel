<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tahun_id')->constrained();
    $table->foreignId('kategori_id')->constrained();
    $table->string('nama_kelas');
    $table->string('penerbit')->default('Nama Sekolah');
    $table->string('cover_path');
    $table->string('file_path');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
