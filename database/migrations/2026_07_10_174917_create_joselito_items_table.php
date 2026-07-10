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
    Schema::create('joselito_items', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('proveedor');
        $table->string('origen');
        $table->decimal('cantidad_actual', 10, 2)->default(0);
        $table->date('fecha_llegada');
        $table->string('observaciones')->nullable();
        $table->boolean('activo')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('joselito_items');
    }
};
