<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            $table->string('numero_orden')->unique();

            $table->foreignId('client_id')
                  ->nullable()
                  ->constrained('clients')
                  ->nullOnDelete();

            $table->enum('tipo_orden', [
                'LOCAL',
                'ENCOMIENDA',
                'SUPERMERCADO',
                'EXPORTACION',
                'MUESTRA'
            ]);

            $table->date('fecha_pedido');

            $table->date('fecha_entrega')
                  ->nullable();

            $table->enum('estado', [
                'COMPLETO',
                'PARCIAL',
                'INCOMPLETO'
            ])->default('INCOMPLETO');

            $table->text('observaciones')
                  ->nullable();

            $table->decimal('subtotal', 12, 2)
                  ->default(0);

            $table->decimal('igv', 12, 2)
                  ->default(0);

            $table->decimal('total', 12, 2)
                  ->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};