@extends('admin/layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Tambah Buku Tahunan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('bukus.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Tahun Akademik -->
    <div class="mb-3">
        <label for="tahun_id" class="form-label">Tahun Akademik</label>
        <select class="form-select" id="tahun_id" name="tahun_id" required>
            <option value="">Pilih Tahun</option>
            @foreach($tahuns as $tahun)
                <option value="{{ $tahun->id }}">{{ $tahun->tahun }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
    <label for="kategori_id" class="form-label">Kategori</label>
    <select class="form-select @error('kategori_id') is-invalid @enderror"
            id="kategori_id" name="kategori_id" required>
        <option value="">Pilih Kategori</option>
        @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama }}
            </option>
        @endforeach
    </select>
    @error('kategori_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
    <!-- Nama Kelas -->
    <div class="mb-3">
        <label for="nama_kelas" class="form-label">Nama Kelas</label>
        <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required>
    </div>

    <!-- Penerbit -->
    <div class="mb-3">
        <label for="penerbit" class="form-label">Penerbit</label>
        <input type="text" class="form-control" id="penerbit" name="penerbit" value="Nama Sekolah" required>
    </div>

    <!-- Cover Buku -->
    <div class="mb-3">
        <label for="cover" class="form-label">Cover Buku</label>
        <input type="file" class="form-control" id="cover" name="cover" accept="image/*" required>
    </div>

    <!-- File Buku -->
    <div class="mb-3">
        <label for="file" class="form-label">File Buku</label>
        <input type="file" class="form-control" id="file" name="file" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
