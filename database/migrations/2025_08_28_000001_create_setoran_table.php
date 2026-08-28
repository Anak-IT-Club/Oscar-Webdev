<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('setoran')) {
            return;
        }

        Schema::create('setoran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('sampah_id')->nullable()->constrained('sampah')->nullOnDelete();
            $table->string('jenis_sampah');
            $table->integer('poin');
            // sumber: manual (dicatat admin), ai (hasil scan), smartbin (nanti dari alat)
            $table->string('sumber')->default('manual');
            $table->string('catatan')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index('jenis_sampah');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setoran');
    }
};
