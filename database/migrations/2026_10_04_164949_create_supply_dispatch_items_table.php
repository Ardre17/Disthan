<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supply_dispatch_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('supply_dispatch_id')
                ->constrained('supply_dispatches')
                ->cascadeOnDelete();

            $table->foreignId('supply_order_item_id')
                ->constrained('supply_order_items')
                ->cascadeOnDelete();

            // Cantidad que realmente salió en este despacho
            $table->decimal('cantidad', 12, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supply_dispatch_items');
    }
};