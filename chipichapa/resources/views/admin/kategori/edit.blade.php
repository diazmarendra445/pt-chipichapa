@extends('layouts.app')
@section('title', 'Edit Kategori')

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
    <h4><i class="bi bi-pencil-square"></i> Edit Kategori</h4>
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow-sm" style="max-width:500px;">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="nama_kategori"
                       class="form-control @error('nama_kategori') is-invalid @enderror"
                       value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                @error('nama_kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-save"></i> Update
            </button>
        </form>
    </div>
</div>
@endsection
