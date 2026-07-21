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
    Schema::create('rechazos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')
              ->constrained('orders')
              ->cascadeOnDelete();
        $table->foreignId('order_detail_id')
              ->constrained('order_details')
              ->cascadeOnDelete();
        $table->decimal('cantidad_rechazada', 10, 2);
        $table->string('motivo');
        $table->string('observaciones')->nullable();
        $table->date('fecha_rechazo');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rechazos');
    }
};
