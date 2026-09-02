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
    Schema::create('order_validations', function (Blueprint $table) {
        $table->id();

        $table->foreignId('order_id')
            ->constrained('orders')
            ->cascadeOnDelete();

        $table->foreignId('usuario_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        $table->enum('estado', [
            'PENDIENTE',
            'EN_PROCESO',
            'COMPLETO',
            'PARCIAL',
            'NO_ENVIADO'
        ])->default('PENDIENTE');

        $table->text('observaciones')->nullable();

        $table->timestamp('fecha_validacion')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_validations');
    }
};
