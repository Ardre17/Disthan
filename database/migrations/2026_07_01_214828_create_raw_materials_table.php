<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_materials', function (Blueprint $table) {

            $table->id();

            // Código interno
            $table->string('code')->unique();

            // Nombre
            $table->string('name');

            // Categoría
            $table->string('category')->nullable();

            // Proveedor
            $table->string('supplier')->nullable();

            $table->string('color')->nullable();

            // Unidad
            $table->enum('unit',[
                'KG',
                'LITROS',
                'UNIDADES'
            ])->default('KG');

            // Stock
            $table->decimal('stock',12,2)->default(0);

            // Stock mínimo
            $table->decimal('minimum_stock',12,2)->default(0);

            // Estado
            $table->enum('status',[
                'DISPONIBLE',
                'STOCK_BAJO',
                'AGOTADO'
            ])->default('DISPONIBLE');

            $table->boolean('active')->default(true);

            // Observaciones
            $table->text('notes')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raw_materials');
    }
};