<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FakturItem extends Model
{
    protected $table = 'faktur_items';

    protected $fillable = [
        'faktur_id',
        'barang_id',
        'nama_barang',
        'kategori_barang',
        'harga_satuan',
        'kuantitas',
        'subtotal',
    ];

    public function faktur()
    {
        return $this->belongsTo(Faktur::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function getSubtotalFormattedAttribute(): string
    {
        return 'Rp. ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getHargaSatuanFormattedAttribute(): string
    {
        return 'Rp. ' . number_format($this->harga_satuan, 0, ',', '.');
    }
}
