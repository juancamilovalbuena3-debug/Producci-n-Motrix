<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // Carro o Moto
            $table->string('marca');
            $table->string('modelo');
            $table->decimal('precio', 10, 2);
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable(); // Imagen del vehículo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
