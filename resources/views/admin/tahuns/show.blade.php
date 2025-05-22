@extends('admin/layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Detail Tahun {{ $tahun->tahun }}</h4>
                    <div>
                        <a href="{{ route('tahuns.edit', $tahun->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('tahuns.index') }}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">Tahun</th>
                                <td>{{ $tahun->tahun }}</td>
                            </tr>
                            <tr>
                                <th>Dibuat Pada</th>
                                <td>{{ $tahun->created_at->format('d F Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Diupdate Pada</th>
                                <td>{{ $tahun->updated_at->format('d F Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <h5 class="mt-4">Daftar Buku Tahun Ini</h5>
                @if($tahun->bukus->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Cover</th>
                                    <th>Nama Kelas</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tahun->bukus as $key => $buku)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if($buku->cover_path)
                                            <img src="{{ asset('storage/'.$buku->cover_path) }}"
                                                 alt="Cover Buku" width="50" class="img-thumbnail">
                                        @else
                                            <span class="text-muted">No Cover</span>
                                        @endif
                                    </td>
                                    <td>{{ $buku->nama_kelas }}</td>
                                    <td>
                                        @if($buku->kategori)
                                            {{ $buku->kategori->nama }}
                                        @else
                                            <span class="text-muted">Tidak ada kategori</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('bukus.show', $buku->id) }}"
                                               class="btn btn-info" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('fotos.index', ['buku_id' => $buku->id]) }}"
                                               class="btn btn-success" title="Kelola Foto">
                                                <i class="bi bi-images"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        Belum ada buku untuk tahun ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<style>
    .img-thumbnail {
        max-height: 50px;
        object-fit: cover;
    }
    .btn-group {
        display: flex;
        gap: 5px;
    }
</style>
@endpush
