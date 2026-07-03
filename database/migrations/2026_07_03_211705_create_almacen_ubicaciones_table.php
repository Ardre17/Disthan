<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('almacen_ubicaciones', function (Blueprint $table) {
            $table->id();

            $table->unsignedTinyInteger('nivel');       // 1 o 2
            $table->enum('tipo', ['RACK', 'ROTACION']); // rack normal o zona poca rotación
            $table->string('fila', 1)->nullable();       // 'A' o 'B' (null en ROTACION)
            $table->unsignedTinyInteger('espacio');      // 1-4 en RACK · 1-10 (N1) o 1-5 (N2) en ROTACION
            $table->unsignedTinyInteger('slot')->nullable(); // 1-4 en RACK · null en ROTACION

            $table->foreignId('product_id')
                  ->nullable()
                  ->constrained('products')
                  ->nullOnDelete();

            $table->decimal('cantidad', 10, 2)->default(0);
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->unique(['nivel', 'tipo', 'fila', 'espacio', 'slot']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('almacen_ubicaciones');
    }
};