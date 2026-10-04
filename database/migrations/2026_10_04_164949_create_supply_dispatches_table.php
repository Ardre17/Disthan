<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supply_dispatches', function (Blueprint $table) {
            $table->id();

            // Ejemplo: VS-000001
            $table->string('numero_salida')->unique();

            $table->foreignId('supply_order_id')
                ->constrained('supply_orders')
                ->cascadeOnDelete();

            $table->dateTime('fecha_salida');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('observaciones')
                ->nullable();

            $table->timestamps();

            $table->index('fecha_salida');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supply_dispatches');
    }
};