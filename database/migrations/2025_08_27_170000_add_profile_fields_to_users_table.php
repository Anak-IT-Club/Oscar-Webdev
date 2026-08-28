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
            if (! Schema::hasColumn('users', 'nisn')) {
                $table->string('nisn')->nullable();
            }
            if (! Schema::hasColumn('users', 'nama')) {
                $table->string('nama')->nullable();
            }
            if (! Schema::hasColumn('users', 'kelas')) {
                $table->string('kelas')->nullable();
            }
            if (! Schema::hasColumn('users', 'jurusan')) {
                $table->string('jurusan')->nullable();
            }
            if (! Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp')->nullable();
            }
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('siswa');
            }
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
