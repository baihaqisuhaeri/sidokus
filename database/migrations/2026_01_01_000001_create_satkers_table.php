<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('satkers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('tingkatan', ['pusat', 'provinsi', 'kabupaten_kota']);
            $table->string('wilayah')->nullable(); // contoh: "DKI Jakarta", "Kab. Bogor"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('satkers');
    }
};
