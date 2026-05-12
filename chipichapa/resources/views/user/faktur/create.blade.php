@extends('layouts.app')
@section('title', 'Buat Faktur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="bi bi-receipt"></i> Buat Faktur</h4>
    <a href="{{ route('user.barang.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali Belanja
    </a>
</div>

<div class="row">
    {{-- Tabel keranjang --}}
    <div class="col-md-8">
        <div class="card shadow-sm mb-3">
            <div class="card-header">
                <strong><i class="bi bi-cart3"></i> Barang dalam Keranjang</strong>
                <small class="text-muted ms-2">No. Invoice: <strong>{{ $nomorInvoice }}</strong></small>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kategori</th>
                            <th>Nama Barang</th>
                            <th>Harga Satuan</th>
                            <th style="width:120px">Kuantitas</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keranjang as $id => $item)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $item['kategori_barang'] }}</span></td>
                                <td>{{ $item['nama_barang'] }}</td>
                                <td>Rp. {{ number_format($item['harga_satuan'], 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('user.keranjang.update', $id) }}" method="POST" class="d-flex gap-1">
                                        @csrf @method('PATCH')
                                        <input type="number" name="kuantitas"
                                               value="{{ $item['kuantitas'] }}"
                                               min="1" class="form-control form-control-sm" style="width:65px">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>Rp. {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('user.keranjang.remove', $id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-primary">
                            <td colspan="4" class="text-end fw-bold">Total Harga:</td>
                            <td colspan="2" class="fw-bold fs-5">
                                Rp. {{ number_format($totalHarga, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Form pengiriman & simpan --}}
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <strong><i class="bi bi-geo-alt"></i> Data Pengiriman</strong>
            </div>
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

                <form action="{{ route('user.faktur.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Alamat Pengiriman <span class="text-danger">*</span></label>
                        <textarea name="alamat_pengiriman"
                                  class="form-control @error('alamat_pengiriman') is-invalid @enderror"
                                  rows="3" minlength="10" maxlength="100" required
                                  placeholder="Masukkan alamat lengkap...">{{ old('alamat_pengiriman') }}</textarea>
                        <div class="form-text">Minimal 10 huruf, maksimal 100 huruf.</div>
                        @error('alamat_pengiriman') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                        <input type="text" name="kode_pos"
                               class="form-control @error('kode_pos') is-invalid @enderror"
                               value="{{ old('kode_pos') }}"
                               maxlength="5" pattern="[0-9]{5}"
                               placeholder="12345" required>
                        <div class="form-text">Harus 5 digit angka.</div>
                        @error('kode_pos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-save"></i> Simpan & Cetak Faktur
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
