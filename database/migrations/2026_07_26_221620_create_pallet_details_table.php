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
    Schema::create('pallet_details', function (Blueprint $table) {

        $table->id();

        $table->foreignId('pallet_id')
              ->constrained('pallets')
              ->cascadeOnDelete();

        $table->foreignId('order_detail_id')
              ->constrained('order_details')
              ->cascadeOnDelete();

        $table->foreignId('product_id')
              ->constrained('products');

        $table->decimal('cantidad',12,2);

        $table->decimal('peso',10,2)->default(0);

        $table->timestamps();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pallet_details');
    }
};
