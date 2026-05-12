@extends('layouts.app')
@section('title', 'Katalog Barang - PT ChipiChapa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="bi bi-shop"></i> Katalog Barang</h4>
    @php $keranjang = session('keranjang', []); @endphp
    @if(count($keranjang) > 0)
        <a href="{{ route('user.faktur.index') }}" class="btn btn-success">
            <i class="bi bi-cart-check"></i> Lihat Keranjang
            <span class="badge bg-light text-dark">{{ count($keranjang) }}</span>
        </a>
    @endif
</div>

<div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3">
    @forelse($barangs as $barang)
        <div class="col">
            <div class="card h-100 shadow-sm {{ $barang->isHabis() ? 'border-danger' : '' }}">
                @if($barang->foto_barang)
                    <img src="{{ asset('storage/' . $barang->foto_barang) }}"
                         class="card-img-top" alt="{{ $barang->nama_barang }}"
                         style="height:180px;object-fit:cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center"
                         style="height:180px;">
                        <i class="bi bi-image text-muted" style="font-size:3rem;"></i>
                    </div>
                @endif

                <div class="card-body">
                    <span class="badge bg-secondary mb-1">{{ $barang->kategori->nama_kategori }}</span>
                    <h6 class="card-title">{{ $barang->nama_barang }}</h6>
                    <p class="card-text fw-bold text-primary">{{ $barang->harga_formatted }}</p>
                    <p class="card-text text-muted small">
                        Stok:
                        @if($barang->isHabis())
                            <span class="text-danger fw-bold">Habis</span>
                        @else
                            <span class="text-success">{{ $barang->jumlah_barang }}</span>
                        @endif
                    </p>
                </div>

                <div class="card-footer bg-transparent">
                    @if($barang->isHabis())
                        <button class="btn btn-sm btn-outline-danger w-100" disabled>
                            <i class="bi bi-x-circle"></i> Barang sudah habis, silakan tunggu hingga barang di-restock ulang
                        </button>
                    @else
                        <form action="{{ route('user.barang.keranjang', $barang) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary w-100">
                                <i class="bi bi-cart-plus"></i> Tambah ke Faktur
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">Belum ada barang tersedia.</div>
        </div>
    @endforelse
</div>

<div class="mt-4">{{ $barangs->links() }}</div>
@endsection
