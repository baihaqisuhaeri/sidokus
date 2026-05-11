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
        Schema::table('dokumentasi', function (Blueprint $table) {
            //
            $table->enum('jenis_surat_suara', ['normal', 'tunanetra'])
              ->default('normal')
              ->after('jenis_pemilu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumentasi', function (Blueprint $table) {
            //
        });
    }
};
