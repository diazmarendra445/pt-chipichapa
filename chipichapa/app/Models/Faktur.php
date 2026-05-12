<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Faktur extends Model
{
    use HasFactory;

    protected $table = 'fakturs';

    protected $fillable = [
        'nomor_invoice',
        'user_id',
        'alamat_pengiriman',
        'kode_pos',
        'total_harga',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(FakturItem::class);
    }

    // Generate nomor invoice: INV-YYYYMMDD-XXXX
    public static function generateNomorInvoice(): string
    {
        $date = Carbon::now()->format('Ymd');
        $last = self::whereDate('created_at', Carbon::today())->count() + 1;
        return 'INV-' . $date . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }

    public function getTotalFormattedAttribute(): string
    {
        return 'Rp. ' . number_format($this->total_harga, 0, ',', '.');
    }
}
