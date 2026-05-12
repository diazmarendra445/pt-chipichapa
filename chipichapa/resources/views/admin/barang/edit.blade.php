@extends('layouts.app')
@section('title', 'Edit Barang')

@section('sidebar')
    <ul class="nav flex-column">
        <li class="nav-item mb-1">
            <a class="nav-link active" href="{{ route('admin.barang.index') }}">
                <i class="bi bi-box-seam"></i> Barang
            </a>
        </li>
        <li class="nav-item mb-1">
            <a class="nav-link" href="{{ route('admin.kategori.index') }}">
                <i class="bi bi-tags"></i> Kategori
            </a>
        </li>
    </ul>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="bi bi-pencil-square"></i> Edit Barang</h4>
    <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.barang.update', $barang) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Kategori Barang <span class="text-danger">*</span></label>
                <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}"
                            {{ (old('kategori_id', $barang->kategori_id) == $k->id) ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                <input type="text" name="nama_barang"
                       class="form-control @error('nama_barang') is-invalid @enderror"
                       value="{{ old('nama_barang', $barang->nama_barang) }}"
                       minlength="5" maxlength="80" required>
                @error('nama_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Harga Barang <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input type="number" name="harga_barang"
                           class="form-control @error('harga_barang') is-invalid @enderror"
                           value="{{ old('harga_barang', $barang->harga_barang) }}"
                           min="0" required>
                </div>
                @error('harga_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Barang <span class="text-danger">*</span></label>
                <input type="number" name="jumlah_barang"
                       class="form-control @error('jumlah_barang') is-invalid @enderror"
                       value="{{ old('jumlah_barang', $barang->jumlah_barang) }}"
                       min="0" required>
                @error('jumlah_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Barang</label>
                @if($barang->foto_barang)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $barang->foto_barang) }}"
                             alt="{{ $barang->nama_barang }}"
                             style="width:100px;height:100px;object-fit:cover;" class="rounded border">
                        <small class="text-muted d-block mt-1">Foto saat ini. Upload baru untuk mengganti.</small>
                    </div>
                @endif
                <input type="file" name="foto_barang"
                       class="form-control @error('foto_barang') is-invalid @enderror"
                       accept="image/*">
                <div class="form-text">Format: JPG, JPEG, PNG, WEBP. Maks 2MB.</div>
                @error('foto_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-warning">
                <i class="bi bi-save"></i> Update Barang
            </button>
        </form>
    </div>
</div>
@endsection
