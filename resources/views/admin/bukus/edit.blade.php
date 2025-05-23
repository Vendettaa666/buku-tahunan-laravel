@extends('admin/layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Buku Tahunan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('bukus.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tahun_id" class="form-label">Tahun</label>
                                <select class="form-select @error('tahun_id') is-invalid @enderror" id="tahun_id" name="tahun_id" required>
                                    <option value="">Pilih Tahun</option>
                                    @foreach($tahuns as $tahun)
                                        <option value="{{ $tahun->id }}" {{ old('tahun_id', $buku->tahun_id) == $tahun->id ? 'selected' : '' }}>
                                            {{ $tahun->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tahun_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nama_kelas" class="form-label">Nama Kelas</label>
                                <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror"
                                       id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas', $buku->nama_kelas) }}" required>
                                @error('nama_kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="penerbit" class="form-label">Penerbit</label>
                                <input type="text" class="form-control @error('penerbit') is-invalid @enderror"
                                       id="penerbit" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}">
                                @error('penerbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kategori_id" class="form-label">Kategori</label>
                                <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id">
                                    <option value="">Tidak Ada Kategori</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_id', $buku->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cover" class="form-label">Cover Buku</label>
                                @if($buku->cover_path)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $buku->cover_path) }}" alt="Current Cover" class="img-thumbnail" width="150">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="remove_cover" name="remove_cover">
                                            <label class="form-check-label" for="remove_cover">
                                                Hapus cover saat disimpan
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('cover') is-invalid @enderror"
                                       id="cover" name="cover" accept="image/*">
                                @error('cover')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Format: JPEG, PNG, JPG, GIF (Maks. 2MB)</div>
                            </div>

                            <div class="mt-4 d-flex justify-content-between">
                                <a href="{{ route('bukus.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    .img-thumbnail {
        max-height: 150px;
        object-fit: cover;
    }
</style>
@endpush
