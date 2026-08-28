<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tukar_poin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('hadiah_id')->constrained('hadiah')->onDelete('cascade');
            $table->integer('poin_dipakai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tukar_poin');
    }
};
