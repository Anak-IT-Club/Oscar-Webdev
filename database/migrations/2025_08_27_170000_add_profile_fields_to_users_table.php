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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nisn')->nullable()->after('name');
            $table->string('nama')->nullable()->after('nisn');
            $table->string('kelas')->nullable()->after('nama');
            $table->string('jurusan')->nullable()->after('kelas');
            $table->string('no_hp')->nullable()->after('jurusan');
            $table->string('role')->default('siswa')->after('no_hp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nisn', 'nama', 'kelas', 'jurusan', 'no_hp', 'role']);
        });
    }
};
