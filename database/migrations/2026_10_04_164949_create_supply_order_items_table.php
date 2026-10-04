<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supply_order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('supply_order_id')
                ->constrained('supply_orders')
                ->cascadeOnDelete();

            /*
             * De qué inventario proviene:
             *
             * LABEL
             * STICKER
             * PRECINTO
             * CAJA
             */
            $table->string('tipo_material');

            /*
             * ID del registro dentro de su propia tabla.
             *
             * LABEL     -> labels.id
             * STICKER   -> stickers.id
             * PRECINTO  -> precintos.id
             * CAJA      -> cajas.id
             */
            $table->unsignedBigInteger('material_id');

            // Cantidad que la planta necesita
            $table->decimal('cantidad_solicitada', 12, 2);

            $table->timestamps();

            $table->index([
                'tipo_material',
                'material_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supply_order_items');
    }
};