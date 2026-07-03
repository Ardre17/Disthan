<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {

            $table->id();

            // Producto terminado
            $table->foreignId('product_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Materia prima
            $table->foreignId('raw_material_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Cliente
            $table->foreignId('client_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Usuario
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Tipo
            $table->enum('movement_type', [

                'PRODUCCION',

                'VENTA',

                'COMPRA',

                'AJUSTE',

                'TRASLADO',

                'DEVOLUCION',

                'MERMA'

            ]);

            // Entrada
            $table->decimal('entry',12,2)->default(0);

            // Salida
            $table->decimal('exit',12,2)->default(0);

            // Stock antes
            $table->decimal('stock_before',12,2);

            // Stock después
            $table->decimal('stock_after',12,2);

            // Documento relacionado
            $table->string('document_number')->nullable();

            // Observaciones
            $table->text('observation')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};