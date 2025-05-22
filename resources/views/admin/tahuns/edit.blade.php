@extends('admin/layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Tahun</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('tahuns.update', $tahun->id) }}" method="POST">
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
