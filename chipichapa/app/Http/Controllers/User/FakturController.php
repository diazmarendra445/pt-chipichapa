<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Faktur;
use App\Models\FakturItem;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FakturController extends Controller
{
    // Halaman cetak faktur (preview keranjang + isi alamat)
    public function index()
    {
        $keranjang = session()->get('keranjang', []);

        if (empty($keranjang)) {
            return redirect()->route('user.barang.index')
                ->with('error', 'Keranjang kosong. Tambahkan barang terlebih dahulu.');
        }

        $totalHarga = collect($keranjang)->sum('subtotal');
        $nomorInvoice = Faktur::generateNomorInvoice();

        return view('user.faktur.create', compact('keranjang', 'totalHarga', 'nomorInvoice'));
    }

    // Simpan faktur
    public function store(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string|min:10|max:100',
            'kode_pos'          => 'required|string|size:5|regex:/^[0-9]{5}$/',
        ], [
            'kode_pos.size'  => 'Kode pos harus tepat 5 digit.',
            'kode_pos.regex' => 'Kode pos harus berupa 5 angka.',
        ]);

        $keranjang = session()->get('keranjang', []);

        if (empty($keranjang)) {
            return redirect()->route('user.barang.index')
                ->with('error', 'Keranjang kosong.');
        }

        DB::beginTransaction();
        try {
            $totalHarga = collect($keranjang)->sum('subtotal');

            $faktur = Faktur::create([
                'nomor_invoice'     => Faktur::generateNomorInvoice(),
                'user_id'           => auth()->id(),
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'kode_pos'          => $request->kode_pos,
                'total_harga'       => $totalHarga,
            ]);

            foreach ($keranjang as $item) {
                FakturItem::create([
                    'faktur_id'       => $faktur->id,
                    'barang_id'       => $item['barang_id'],
                    'nama_barang'     => $item['nama_barang'],
                    'kategori_barang' => $item['kategori_barang'],
                    'harga_satuan'    => $item['harga_satuan'],
                    'kuantitas'       => $item['kuantitas'],
                    'subtotal'        => $item['subtotal'],
                ]);

                // Kurangi stok
                Barang::where('id', $item['barang_id'])
                    ->decrement('jumlah_barang', $item['kuantitas']);
            }

            session()->forget('keranjang');
            DB::commit();

            return redirect()->route('user.faktur.show', $faktur->id)
                ->with('success', 'Faktur berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan faktur: ' . $e->getMessage());
        }
    }

    // Tampilkan faktur tersimpan (halaman cetak)
    public function show(Faktur $faktur)
    {
        // Pastikan hanya pemilik faktur yang bisa lihat
        if ($faktur->user_id !== auth()->id()) {
            abort(403);
        }

        $faktur->load(['items', 'user']);
        return view('user.faktur.show', compact('faktur'));
    }

    // Riwayat faktur user
    public function history()
    {
        $fakturs = Faktur::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.faktur.history', compact('fakturs'));
    }
}
