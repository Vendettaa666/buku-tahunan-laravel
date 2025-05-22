@extends('admin/layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tambah Tahun Akademik</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('tahuns.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun Akademik</label>
                        <input type="text"
                               class="form-control @error('tahun') is-invalid @enderror"
                               id="tahun"
                               name="tahun"
                               value="{{ old('tahun') }}"
                               placeholder="Contoh: 2023/2024"
                               required>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tahuns.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
