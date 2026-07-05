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
    Schema::create('precintos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->enum('color', ['VERDE','BLANCO','NEGRO']);
        $table->decimal('stock_actual', 10, 2)->default(0);
        $table->decimal('stock_minimo', 10, 2)->default(0);
        $table->boolean('activo')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precintos');
    }
};
