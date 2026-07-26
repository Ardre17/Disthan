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
    Schema::create('pallets', function (Blueprint $table) {

        $table->id();

        $table->foreignId('order_id')
              ->constrained('orders')
              ->cascadeOnDelete();

        $table->string('codigo')->unique();

        $table->enum('estado', [
            'ABIERTO',
            'COMPLETO',
            'CARGADO'
        ])->default('ABIERTO');

        $table->decimal('peso_neto',10,2)->default(0);
        $table->decimal('peso_bruto',10,2)->default(0);

        $table->decimal('altura',8,2)->nullable();
        $table->decimal('ancho',8,2)->nullable();
        $table->decimal('largo',8,2)->nullable();

        $table->text('observaciones')->nullable();

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pallets');
    }
};
