@extends('admin/layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2>Daftar Tahun</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('tahuns.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Tahun
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Cover</th>
                        <th>Tahun</th>
                        <th>Jumlah Buku</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tahuns as $key => $tahun)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            @if($tahun->cover_image)
                                <img src="{{ $tahun->cover_image }}" alt="Cover" class="img-thumbnail" style="max-width: 100px;">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td>{{ $tahun->tahun }}</td>
                        <td>{{ $tahun->bukus_count ?? $tahun->bukus->count() }}</td>
                        <td>
                            <a href="{{ route('tahuns.show', $tahun->id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('tahuns.edit', $tahun->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('tahuns.destroy', $tahun->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data tahun</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .img-thumbnail {
        max-height: 200px;
        object-fit: cover;
    }
</style>
@endpush
