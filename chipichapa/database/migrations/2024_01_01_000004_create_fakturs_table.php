<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fakturs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_invoice')->unique(); // INV-YYYYMMDD-XXXX
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('alamat_pengiriman');       // min 10, max 100
            $table->string('kode_pos', 5);             // 5 digit
            $table->integer('total_harga');
            $table->timestamps();
        });

        Schema::create('faktur_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faktur_id')->constrained('fakturs')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->string('nama_barang');
            $table->string('kategori_barang');
            $table->integer('harga_satuan');
            $table->integer('kuantitas');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faktur_items');
        Schema::dropIfExists('fakturs');
    }
};
