<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel kategori berkas
        Schema::create('kategori_berkas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // Tabel sub kategori berkas
        Schema::create('sub_kategori_berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_berkas')->cascadeOnDelete();
            $table->string('nama');
            $table->boolean('has_nomor_surat')->default(true); // apakah jenis ini biasanya punya nomor surat
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // Update tabel berkas
        Schema::table('berkas', function (Blueprint $table) {
            $table->foreignId('sub_kategori_id')->nullable()->constrained('sub_kategori_berkas')->nullOnDelete()->after('judul');
            $table->string('nomor_surat')->nullable()->after('sub_kategori_id');
            // hapus kolom kategori lama (string)
            $table->dropColumn('kategori');
        });
    }

    public function down(): void
    {
        Schema::table('berkas', function (Blueprint $table) {
            $table->dropForeign(['sub_kategori_id']);
            $table->dropColumn(['sub_kategori_id', 'nomor_surat']);
            $table->string('kategori')->nullable();
        });

        Schema::dropIfExists('sub_kategori_berkas');
        Schema::dropIfExists('kategori_berkas');
    }
};
