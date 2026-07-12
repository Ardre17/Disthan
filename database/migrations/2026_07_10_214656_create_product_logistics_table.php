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
    Schema::create('product_logistics', function (Blueprint $table) {
        $table->id();

        $table->foreignId('product_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->decimal('largo_cm', 8, 2);
        $table->decimal('ancho_cm', 8, 2);
        $table->decimal('alto_cm', 8, 2);

        $table->decimal('peso_caja', 8, 2)->default(0);

        $table->integer('max_cajas_pallet')->default(0);
        $table->integer('max_niveles')->default(0);

        $table->decimal('altura_maxima_pallet', 8, 2)->default(160);

        $table->boolean('permite_mezcla')->default(true);

        $table->enum('orientacion', [
            'NORMAL',
            'ACOSTADO',
            'VERTICAL'
        ])->default('NORMAL');

        $table->boolean('activo')->default(true);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_logistics');
    }
};
