<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {

            $table->id();

            $table->foreignId('order_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('product_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->decimal(
                'cantidad_solicitada',
                12,
                2
            );

            $table->decimal(
                'cantidad_despachada',
                12,
                2
            )->default(0);

            $table->decimal(
                'precio_unitario',
                12,
                2
            )->default(0);

            $table->decimal(
                'subtotal',
                12,
                2
            )->default(0);

            $table->enum('estado_item', [
                'COMPLETO',
                'PARCIAL',
                'INCOMPLETO'
            ])->default('INCOMPLETO');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};