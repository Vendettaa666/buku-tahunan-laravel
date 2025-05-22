@extends('admin/layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Detail Buku Tahunan</h4>
                        <a href="{{ route('bukus.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($buku->cover_path)
                                <img src="{{ asset('storage/'.$buku->cover_path) }}"
                                     alt="Cover Buku"
                                     class="img-fluid rounded mb-3" style="max-height: 300px;">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Tahun Akademik</th>
                                    <td>{{ $buku->tahun->tahun }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Kelas</th>
                                    <td>{{ $buku->nama_kelas }}</td>
                                </tr>
                                <tr>
                                    <th>Penerbit</th>
                                    <td>{{ $buku->penerbit }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>
                                        @if($buku->kategori)
                                            {{ $buku->kategori->nama }}
                                            @if($buku->kategori->deskripsi)
                                                <br><small class="text-muted">{{ $buku->kategori->deskripsi }}</small>
                                            @endif
                                        @else
                                            Tidak ada kategori
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>File Buku</th>
                                    <td>
                                        @if($buku->file_path)
                                            <a href="{{ asset('storage/'.$buku->file_path) }}"
                                               class="btn btn-sm btn-success" download>
                                                <i class="bi bi-download"></i> Download File
                                            </a>
                                        @else
                                            Tidak ada file
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <div class="mt-4">
                                <a href="{{ route('bukus.edit', $buku->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('bukus.destroy', $buku->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus buku ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
