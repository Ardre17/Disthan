<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supply_orders', function (Blueprint $table) {
            $table->id();

            // Ejemplo: OS-000001
            $table->string('numero_orden')->unique();

            // Planta de destino
            $table->string('planta');

            // Producto que se está produciendo
            $table->foreignId('product_id')
                ->nullable()
                ->constrained('products')
                ->nullOnDelete();

            // Datos de producción
            $table->decimal('cantidad_produccion', 12, 2)
                ->nullable();

            $table->string('lote')
                ->nullable();

            $table->date('fecha_solicitud');

            $table->date('fecha_requerida')
                ->nullable();

            $table->string('estado')
                ->default('PENDIENTE');

            $table->text('observaciones')
                ->nullable();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('planta');
            $table->index('estado');
            $table->index('fecha_solicitud');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supply_orders');
    }
};