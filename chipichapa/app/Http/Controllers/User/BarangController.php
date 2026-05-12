<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Katalog semua barang
    public function index()
    {
        $barangs = Barang::with('kategori')->latest()->paginate(12);
        return view('user.barang.index', compact('barangs'));
    }

    // Tambah ke keranjang (session)
    public function addToKeranjang(Request $request, Barang $barang)
    {
        if ($barang->isHabis()) {
            return back()->with('error', 'Barang sudah habis, silakan tunggu hingga barang di-restock ulang.');
        }

        $keranjang = session()->get('keranjang', []);
        $key = $barang->id;

        if (isset($keranjang[$key])) {
            $newQty = $keranjang[$key]['kuantitas'] + 1;
            // Jangan melebihi stok
            if ($newQty > $barang->jumlah_barang) {
                return back()->with('error', 'Kuantitas melebihi stok yang tersedia.');
            }
            $keranjang[$key]['kuantitas'] = $newQty;
            $keranjang[$key]['subtotal']  = $barang->harga_barang * $newQty;
        } else {
            $keranjang[$key] = [
                'barang_id'      => $barang->id,
                'nama_barang'    => $barang->nama_barang,
                'kategori_barang'=> $barang->kategori->nama_kategori,
                'harga_satuan'   => $barang->harga_barang,
                'kuantitas'      => 1,
                'subtotal'       => $barang->harga_barang,
            ];
        }

        session()->put('keranjang', $keranjang);
        return back()->with('success', $barang->nama_barang . ' ditambahkan ke faktur.');
    }

    // Update kuantitas di keranjang
    public function updateKeranjang(Request $request, $barangId)
    {
        $request->validate(['kuantitas' => 'required|integer|min:1']);

        $keranjang = session()->get('keranjang', []);
        $barang = Barang::findOrFail($barangId);

        if ($request->kuantitas > $barang->jumlah_barang) {
            return back()->with('error', 'Kuantitas melebihi stok yang tersedia.');
        }

        if (isset($keranjang[$barangId])) {
            $keranjang[$barangId]['kuantitas'] = $request->kuantitas;
            $keranjang[$barangId]['subtotal']  = $barang->harga_barang * $request->kuantitas;
            session()->put('keranjang', $keranjang);
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    // Hapus item dari keranjang
    public function removeFromKeranjang($barangId)
    {
        $keranjang = session()->get('keranjang', []);
        unset($keranjang[$barangId]);
        session()->put('keranjang', $keranjang);

        return back()->with('success', 'Barang dihapus dari keranjang.');
    }
}
