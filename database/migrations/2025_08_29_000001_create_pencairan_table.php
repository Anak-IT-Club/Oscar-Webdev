<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pencairan')) {
            return;
        }

        Schema::create('pencairan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('poin');
            $table->integer('nominal');
            $table->string('metode');
            $table->string('tujuan')->nullable();
            $table->string('status')->default('pending');
            $table->string('catatan_admin')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pencairan');
    }
};
