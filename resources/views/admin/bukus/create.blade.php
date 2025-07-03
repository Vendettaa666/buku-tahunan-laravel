@extends('admin/layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10 col-sm-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fs-5">Tambah Buku Tahunan</h4>
                <a href="{{ route('bukus.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('bukus.store') }}" method="POST" enctype="multipart/form-data" id="formBuku">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <!-- Tahun Akademik -->
                            <div class="mb-3">
                                <label for="tahun_id" class="form-label">Tahun Akademik</label>
                                <select class="form-select @error('tahun_id') is-invalid @enderror" id="tahun_id" name="tahun_id" required>
                                    <option value="">Pilih Tahun</option>
                                    @foreach($tahuns as $tahun)
                                        <option value="{{ $tahun->id }}" {{ old('tahun_id') == $tahun->id ? 'selected' : '' }}>
                                            {{ $tahun->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tahun_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div class="mb-3">
                                <label for="kategori_id" class="form-label">Kategori</label>
                                <select class="form-select @error('kategori_id') is-invalid @enderror"
                                        id="kategori_id" name="kategori_id">
                                    <option value="">Tidak Ada Kategori</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Pilih kategori yang sesuai. Jika tidak menemukan kategori "Siswa" atau "Siswi", tambahkan terlebih dahulu di menu Kategori.</small>
                                @error('kategori_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nama Kelas -->
                            <div class="mb-3">
                                <label for="nama_kelas" class="form-label">Nama Kelas</label>
                                <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas') }}" required>
                                @error('nama_kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <!-- Penerbit -->
                            <div class="mb-3">
                                <label for="penerbit" class="form-label">Penerbit</label>
                                <input type="text" class="form-control @error('penerbit') is-invalid @enderror" id="penerbit" name="penerbit" value="{{ old('penerbit', 'SMKN 1 Lumajang') }}" required>
                                @error('penerbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Cover Buku -->
                            <div class="mb-3">
                                <label for="cover" class="form-label">Cover Buku</label>
                                <input type="file" class="form-control @error('cover') is-invalid @enderror" id="cover" name="cover" accept="image/*" required>
                                <small class="text-muted">Format: JPEG, PNG, JPG, GIF (Maks. 5MB). Dimensi ideal: 800x1200px.</small>
                                @error('cover')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- File Buku -->
                            <div class="mb-3">
                                <label for="file" class="form-label">File Buku</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }

        .card-header .btn {
            align-self: flex-start;
        }

        .form-control, .form-select {
            font-size: 0.9rem;
        }

        small.text-muted {
            font-size: 0.7rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formBuku');
        const kategoriSelect = document.getElementById('kategori_id');

        form.addEventListener('submit', function(e) {
            // Log form data before submission
            console.log('Submitting form with kategori_id:', kategoriSelect.value);

            // If kategori_id is empty string, ensure it's properly handled
            if (kategoriSelect.value === '') {
                console.log('Empty kategori_id detected, will be converted to null');
            }
        });
    });
</script>
@endpush
