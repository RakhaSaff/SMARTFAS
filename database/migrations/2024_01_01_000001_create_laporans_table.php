<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nomor_tiket')->unique();
            $table->string('nama_barang', 30);
            $table->enum('jenis_barang', ['elektronik', 'non-elektronik']);
            $table->string('tempat_utama');
            $table->string('sub_lokasi')->nullable();
            $table->string('lantai_kelas')->nullable();
            $table->string('tempat_label');
            $table->text('deskripsi');
            $table->string('foto_atas')->nullable();
            $table->string('foto_bawah')->nullable();
            $table->string('foto_kanan')->nullable();
            $table->string('foto_kiri')->nullable();
            $table->string('foto_depan')->nullable();
            $table->string('foto_belakang')->nullable();
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
