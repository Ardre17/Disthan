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
    Schema::create('joselito_movements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('joselito_item_id')
              ->constrained('joselito_items')
              ->cascadeOnDelete();
        $table->enum('tipo', ['ENTRADA','SALIDA']);
        $table->decimal('cantidad', 10, 2);
        $table->string('motivo')->nullable();
        $table->string('destino')->nullable();
        $table->decimal('saldo_post', 10, 2)->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('joselito_movements');
    }
};
