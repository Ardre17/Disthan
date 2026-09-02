<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('order_validation_details', function (Blueprint $table) {
        $table->id();

        $table->foreignId('order_validation_id')
            ->constrained('order_validations')
            ->cascadeOnDelete();

        $table->foreignId('order_detail_id')
            ->constrained('order_details')
            ->cascadeOnDelete();

        $table->enum('estado', [
            'PENDIENTE',
            'COMPLETO',
            'PARCIAL',
            'NO_ENVIADO'
        ])->default('PENDIENTE');

        $table->decimal('cantidad_solicitada', 12, 2);

        $table->decimal('cantidad_validada', 12, 2)
            ->default(0);

        $table->string('codigo_escaneado', 100)
            ->nullable();

        $table->text('observaciones')
            ->nullable();

        $table->timestamps();

        $table->unique([
            'order_validation_id',
            'order_detail_id'
        ]);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_validation_details');
    }
};
