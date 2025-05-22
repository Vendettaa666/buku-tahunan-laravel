@extends('admin/layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Daftar Kategori Buku</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('kategoris.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Kategori
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
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoris as $key => $kategori)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $kategori->nama }}</td>
                            <td>{{ $kategori->deskripsi ?? '-' }}</td>
                            <td>
                                <a href="{{ route('kategoris.edit', $kategori->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('kategoris.destroy', $kategori->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus kategori ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
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
