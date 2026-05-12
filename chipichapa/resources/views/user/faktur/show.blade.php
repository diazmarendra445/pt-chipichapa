@extends('layouts.app')
@section('title', 'Faktur ' . $faktur->nomor_invoice)

@push('styles')
<style>
    @media print {
        nav, .btn, .no-print { display: none !important; }
        body { background: white !important; }
        .card { border: none !important; box-shadow: none !important; }
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-3 no-print">
            <h4><i class="bi bi-receipt-cutoff"></i> Detail Faktur</h4>
            <div>
                <a href="{{ route('user.barang.index') }}" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="bi bi-printer"></i> Cetak Faktur
                </button>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body p-4">
                {{-- Header Faktur --}}
                <div class="row mb-4">
                    <div class="col-6">
                        <h3 class="fw-bold text-primary">PT ChipiChapa</h3>
                        <small class="text-muted">Platform Penjualan Barang</small>
                    </div>
                    <div class="col-6 text-end">
                        <h5 class="fw-bold">FAKTUR PENJUALAN</h5>
                        <p class="mb-1"><strong>No. Invoice:</strong> {{ $faktur->nomor_invoice }}</p>
                        <p class="mb-1"><strong>Tanggal:</strong> {{ $faktur->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <hr>

                {{-- Info Pembeli & Pengiriman --}}
                <div class="row mb-4">
                    <div class="col-6">
                        <h6 class="fw-bold">Data Pembeli:</h6>
                        <p class="mb-1">{{ $faktur->user->nama_lengkap }}</p>
                        <p class="mb-1">{{ $faktur->user->email }}</p>
                        <p class="mb-0">{{ $faktur->user->nomor_hp }}</p>
                    </div>
                    <div class="col-6">
                        <h6 class="fw-bold">Alamat Pengiriman:</h6>
                        <p class="mb-1">{{ $faktur->alamat_pengiriman }}</p>
                        <p class="mb-0"><strong>Kode Pos:</strong> {{ $faktur->kode_pos }}</p>
                    </div>
                </div>

                {{-- Tabel Barang --}}
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Kategori</th>
                            <th>Nama Barang</th>
                            <th>Harga Satuan</th>
                            <th>Kuantitas</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faktur->items as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->kategori_barang }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>Rp. {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td>{{ $item->nama_barang }} x{{ $item->kuantitas }}</td>
                                <td>Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-success">
                            <td colspan="5" class="text-end fw-bold fs-5">TOTAL:</td>
                            <td class="fw-bold fs-5">
                                Rp. {{ number_format($faktur->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div class="text-center mt-4">
                    <small class="text-muted">
                        Terima kasih telah berbelanja di PT ChipiChapa!
                        Faktur ini dikeluarkan secara otomatis oleh sistem.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
