<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_orders', function (Blueprint $table) {

            $table->id();

            // Número de orden
            $table->string('number')->unique();

            // Producto terminado
            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnUpdate();

            // Materia prima utilizada
            $table->foreignId('raw_material_id')
                ->constrained()
                ->cascadeOnUpdate();

            // Cantidad producida
            $table->decimal('produced_quantity',12,2);

            // Cantidad consumida
            $table->decimal('consumed_quantity',12,2);

            // Observación
            $table->text('observation')->nullable();

            // Usuario
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Estado
            $table->enum('status',[
                'BORRADOR',
                'EN_PRODUCCION',
                'FINALIZADA',
                'ANULADA'
            ])->default('BORRADOR');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_orders');
    }
};