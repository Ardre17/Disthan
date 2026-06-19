<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            // Identificación
            $table->string('sku')->unique();
            $table->string('barcode')->nullable()->unique();

            // Información principal
            $table->string('nombre');
            $table->string('marca')->nullable();
            $table->string('categoria')->nullable();
            $table->text('descripcion')->nullable();
            // Imagen
            $table->string('imagen')->nullable();

            // Producción
            $table->string('lote')->nullable();
            $table->date('fecha_produccion')->nullable();
            $table->date('fecha_vencimiento')->nullable();

            // Logística
            $table->integer('cantidad_por_caja')->default(1);

            $table->enum('rotacion', [
                'MUY_ALTA',
                'ALTA',
                'MEDIA',
                'BAJA'
            ])->default('MEDIA');

            // Inventario
            $table->decimal('stock', 12, 2)->default(0);
            $table->decimal('stock_minimo', 12, 2)->default(0);

            // Estado
            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};