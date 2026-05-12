@extends('layouts.app')
@section('title', 'Manajemen Kategori')

@section('sidebar')
    <ul class="nav flex-column">
        <li class="nav-item mb-1">
            <a class="nav-link" href="{{ route('admin.barang.index') }}">
                <i class="bi bi-box-seam"></i> Barang
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link active" href="{{ route('admin.kategori.index') }}">
                <i class="bi bi-tags"></i> Kategori
            </a>
        </li>
    </ul>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="bi bi-tags"></i> Daftar Kategori</h4>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Kategori
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $i => $kategori)
                    <tr>
                        <td>{{ $kategoris->firstItem() + $i }}</td>
                        <td>{{ $kategori->nama_kategori }}</td>
                        <td><span class="badge bg-info text-dark">{{ $kategori->barangs_count }}</span></td>
                        <td>
                            <a href="{{ route('admin.kategori.edit', $kategori) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin hapus kategori ini? Semua barang dalam kategori ini akan ikut terhapus.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $kategoris->links() }}</div>
@endsection
