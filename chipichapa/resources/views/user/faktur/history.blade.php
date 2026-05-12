@extends('layouts.app')
@section('title', 'Riwayat Faktur')

@section('content')
<h4 class="mb-3"><i class="bi bi-clock-history"></i> Riwayat Faktur Saya</h4>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>No. Invoice</th>
                    <th>Tanggal</th>
                    <th>Alamat</th>
                    <th>Kode Pos</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fakturs as $i => $faktur)
                    <tr>
                        <td>{{ $fakturs->firstItem() + $i }}</td>
                        <td><code>{{ $faktur->nomor_invoice }}</code></td>
                        <td>{{ $faktur->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ Str::limit($faktur->alamat_pengiriman, 40) }}</td>
                        <td>{{ $faktur->kode_pos }}</td>
                        <td class="fw-bold">Rp. {{ number_format($faktur->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('user.faktur.show', $faktur) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada faktur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $fakturs->links() }}</div>
@endsection
