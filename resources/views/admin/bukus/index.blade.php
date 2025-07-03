@extends('admin/layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-6 col-sm-12 mb-2">
        <h2 class="fs-3">Daftar Buku Tahunan</h2>
    </div>
    <div class="col-md-6 col-sm-12 text-md-end text-center mb-2">
        <a href="{{ route('bukus.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Buku
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
                        <th width="50">No</th>
                        <th width="80">Cover</th>
                        <th>Nama Kelas</th>
                        <th width="100">Tahun</th>
                        <th width="120">Kategori</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukus as $key => $buku)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            @if($buku->cover_path)
                                <img src="{{ asset('storage/' . $buku->cover_path) }}" alt="Cover Buku" class="img-thumbnail">
                            @else
                                <span class="text-muted">Tidak ada cover</span>
                            @endif
                        </td>
                        <td>{{ $buku->nama_kelas }}</td>
                        <td>{{ $buku->tahun->tahun }}</td>
                        <td>
                            @if($buku->kategori)
                                {{ $buku->kategori->nama }}
                            @else
                                <span class="text-muted">Tidak ada kategori</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                <a href="{{ route('bukus.show', $buku->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('bukus.edit', $buku->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('bukus.destroy', $buku->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('fotos.index', ['buku_id' => $buku->id]) }}" class="btn btn-sm btn-success" title="Kelola Foto">
                                    <i class="bi bi-images"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data buku</td>
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
        max-height: 60px;
        max-width: 60px;
        object-fit: cover;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .table th, .table td {
            font-size: 0.9rem;
            padding: 0.5rem;
        }

        .btn-sm {
            padding: 0.25rem 0.4rem;
            font-size: 0.75rem;
        }

        .img-thumbnail {
            max-height: 50px;
            max-width: 50px;
        }
    }

    @media (max-width: 576px) {
        .table th, .table td {
            font-size: 0.8rem;
            padding: 0.4rem;
        }

        .btn-sm {
            padding: 0.2rem 0.3rem;
            font-size: 0.7rem;
        }

        .img-thumbnail {
            max-height: 40px;
            max-width: 40px;
        }
    }
</style>
@endpush
