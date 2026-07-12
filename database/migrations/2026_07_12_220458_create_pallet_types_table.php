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
    Schema::create('pallet_types', function (Blueprint $table) {

        $table->id();

        $table->string('nombre');

        $table->decimal('largo_cm', 8, 2);

        $table->decimal('ancho_cm', 8, 2);

        $table->decimal('altura_maxima_cm', 8, 2);

        $table->decimal('peso_maximo_kg', 8, 2);

        $table->boolean('activo')->default(true);

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('pallet_types');
}
};
