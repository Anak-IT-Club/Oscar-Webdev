<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('setoran', function (Blueprint $table) {
            if (! Schema::hasColumn('setoran', 'status')) {
                $table->string('status')->default('disetujui')->after('sumber');
            }
            if (! Schema::hasColumn('setoran', 'foto')) {
                $table->string('foto')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('setoran', function (Blueprint $table) {
            if (Schema::hasColumn('setoran', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('setoran', 'foto')) {
                $table->dropColumn('foto');
            }
        });
    }
};
