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
    Schema::create('labels', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('idioma');        // ES / PT / EN
        $table->string('pais')->nullable();   // solo ES
        $table->string('zona')->nullable();   // solo PT
        $table->string('formato')->nullable();
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
        Schema::dropIfExists('labels');
    }
};
