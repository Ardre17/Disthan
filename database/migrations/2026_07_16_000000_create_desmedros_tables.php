<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cabecera: representa la "caja" física de desmedro
        Schema::create('desmedros', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique(); // Ej: DSM-000123, se genera automático
            $table->foreignId('user_id')->constrained('users');
            $table->text('motivo')->nullable(); // observación general de la caja
            $table->enum('estado', ['borrador', 'registrado'])->default('borrador');
            $table->timestamp('registrado_at')->nullable();
            $table->timestamps();
        });

        // Detalle: cada producto dentro de la caja
        Schema::create('desmedro_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desmedro_id')->constrained('desmedros')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('products');
            $table->decimal('cantidad', 12, 2);
            $table->decimal('stock_antes', 12, 2)->nullable(); // snapshot para auditoría
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desmedro_detalles');
        Schema::dropIfExists('desmedros');
    }
};