<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            if (!Schema::hasColumn('vehiculos', 'imagen')) {
                $table->string('imagen')->nullable()->after('descripcion');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            if (Schema::hasColumn('vehiculos', 'imagen')) {
                $table->dropColumn('imagen');
            }
        });
    }
};
