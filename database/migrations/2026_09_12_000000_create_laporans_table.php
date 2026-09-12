<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelapor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_pelapor')->nullable();
            $table->string('kontak_pelapor')->nullable();
            $table->foreignId('terlapor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('pekerjaan_id')->nullable()->constrained('pekerjaans')->nullOnDelete();
            $table->string('kategori')->default('lainnya'); // penipuan_loker, upah_tidak_sesuai, pelanggaran_sop, kontak_palsu, pekerja_mangkir, lainnya
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('bukti_lampiran')->nullable();
            $table->enum('status', ['menunggu', 'proses', 'selesai', 'ditolak'])->default('menunggu');
            $table->text('tindakan_superadmin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};

