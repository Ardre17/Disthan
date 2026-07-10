<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_entries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                  ->constrained('products')
                  ->cascadeOnDelete();

            $table->decimal('quantity', 10, 2);          // cantidad que ingresa
            $table->decimal('stock_before', 10, 2);      // stock antes de la entrada
            $table->decimal('stock_after', 10, 2);       // stock después de la entrada

            $table->string('supplier')->nullable();       // proveedor / origen
            $table->string('lote')->nullable();           // número de lote
            $table->date('fecha_vencimiento')->nullable();
            $table->text('observation')->nullable();

            $table->foreignId('user_id')                 // quién registró
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_entries');
    }
};