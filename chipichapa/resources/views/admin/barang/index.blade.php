@extends('layouts.app')
@section('title', 'Manajemen Barang - Admin')

@section('sidebar')
    <ul class="nav flex-column">
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}"
               href="{{ route('admin.barang.index') }}">
                <i class="bi bi-box-seam"></i> Barang
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}"
               href="{{ route('admin.kategori.index') }}">
                <i class="bi bi-tags"></i> Kategori
            </a>
        </li>
    </ul>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="bi bi-box-seam"></i> Daftar Barang</h4>
    <a href="{{ route('admin.barang.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Barang
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $i => $barang)
                    <tr>
                        <td>{{ $barangs->firstItem() + $i }}</td>
                        <td>
                            @if($barang->foto_barang)
                                <img src="{{ asset('storage/' . $barang->foto_barang) }}"
                                     alt="{{ $barang->nama_barang }}"
                                     style="width:50px;height:50px;object-fit:cover;" class="rounded">
                            @else
                                <span class="text-muted"><i class="bi bi-image" style="font-size:2rem;"></i></span>
                            @endif
                        </td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td><span class="badge bg-secondary">{{ $barang->kategori->nama_kategori }}</span></td>
                        <td>{{ $barang->harga_formatted }}</td>
                        <td>
                            @if($barang->isHabis())
                                <span class="badge bg-danger">Habis</span>
                            @else
                                <span class="badge bg-success">{{ $barang->jumlah_barang }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.barang.edit', $barang) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.barang.destroy', $barang) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin hapus barang ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada barang.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $barangs->links() }}</div>
@endsection
