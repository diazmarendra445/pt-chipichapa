<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'kategori_id',
        'nama_barang',
        'harga_barang',
        'jumlah_barang',
        'foto_barang',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function isHabis(): bool
    {
        return $this->jumlah_barang <= 0;
    }

    // Format harga dengan Rp.
    public function getHargaFormattedAttribute(): string
    {
        return 'Rp. ' . number_format($this->harga_barang, 0, ',', '.');
    }
}
