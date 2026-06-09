<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user'])->default('user')->after('email');
            $table->foreignId('satker_id')->nullable()->constrained('satkers')->nullOnDelete()->after('role');
            $table->string('nip', 20)->nullable()->after('satker_id');
            $table->string('jabatan')->nullable()->after('nip');
            $table->string('no_hp', 20)->nullable()->after('jabatan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['satker_id']);
            $table->dropColumn(['role', 'satker_id', 'nip', 'jabatan', 'no_hp']);
        });
    }
};
