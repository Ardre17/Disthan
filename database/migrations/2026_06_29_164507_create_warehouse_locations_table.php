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
    Schema::create('warehouse_locations', function (Blueprint $table) {

        $table->id();

        // Código de ubicación (A01, A02...)
        $table->string('code')->unique();

        // Rack (A, B, C...)
        $table->string('rack');
        $table->string('rack_name')->nullable();

        // Nivel del almacén
        $table->tinyInteger('level');

        // Posición dentro del rack
        $table->tinyInteger('row');
        $table->tinyInteger('column');

        // Estado de la ubicación
        $table->enum('status', [
            'FREE',
            'OCCUPIED',
            'RESERVED',
            'BLOCKED'
        ])->default('FREE');

        // Producto almacenado
        $table->foreignId('product_id')
            ->nullable()
            ->constrained('products')
            ->nullOnDelete();

        // Cantidad actual
        $table->integer('stock')->default(0);

        // Capacidad máxima
        $table->integer('capacity')->default(200);
        // Peso máximo soportado (kg)
        $table->decimal('max_weight',10,2)->default(0);

        // Observaciones
        $table->text('notes')->nullable();

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_locations');
    }
};
