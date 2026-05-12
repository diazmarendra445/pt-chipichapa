<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');          // min 3, max 40
            $table->string('email')->unique();        // harus @gmail.com
            $table->string('password');               // min 6, max 12
            $table->string('nomor_hp');               // diawali 08
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->string('id_admin')->nullable();   // hanya untuk admin
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
