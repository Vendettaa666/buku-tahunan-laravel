@extends('admin/layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Tahun</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('tahuns.update', $tahun->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="text" class="form-control @error('tahun') is-invalid @enderror"
                               id="tahun" name="tahun" value="{{ old('tahun', $tahun->tahun) }}" required>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Cover Image</label>
                        @if($tahun->cover_image)
                            <div class="mb-2">
                                <img src="{{ $tahun->cover_image_url }}" alt="Current Cover" class="img-thumbnail" style="max-height: 200px">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('cover_image') is-invalid @enderror"
                               id="cover_image" name="cover_image" accept="image/*">
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tahuns.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
@endpush
