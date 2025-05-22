

@extends('admin/layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <div class="btn-group">
            <a href="{{ route('tahuns.create') }}" class="btn btn-primary btn-sm me-2">
                <i class="bi bi-plus-circle"></i> Tambah Tahun
            </a>
            <a href="{{ route('kategoris.create') }}" class="btn btn-info btn-sm me-2">
                <i class="bi bi-tags"></i> Tambah Kategori
            </a>
            <a href="{{ route('bukus.create') }}" class="btn btn-success btn-sm">
                <i class="bi bi-book"></i> Tambah Buku
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Buku Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stat-title">Total Buku</div>
                            <div class="stat-value">{{ $totalBuku }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-journal-bookmark stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Kategori Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stat-title">Total Kategori</div>
                            <div class="stat-value">{{ $totalKategori }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-tags stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Tahun Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card border-left-info h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="stat-title">Total Tahun</div>
                            <div class="stat-value">{{ $totalTahun }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar3 stat-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Daftar Tahun -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Tahun Akademik</h6>
            <a href="{{ route('tahuns.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus"></i> Tambah Tahun
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Tahun Akademik</th>
                            <th>Jumlah Buku</th>
                            <th>Terakhir Diupdate</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tahuns as $tahun)
                        <tr>
                            <td>{{ $tahun->tahun }}</td>
                            <td>{{ $tahun->bukus->count() }}</td>
                            <td>{{ $tahun->updated_at->format('d M Y H:i') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('tahuns.edit', $tahun->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('tahuns.show', $tahun->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('tahuns.destroy', $tahun->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Hapus tahun ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
