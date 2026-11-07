<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_forecast_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->unique()->constrained('products')->cascadeOnDelete();
            $table->unsignedSmallInteger('lead_time_days')->default(3);
            $table->unsignedSmallInteger('safety_days')->default(3);
            $table->unsignedSmallInteger('coverage_days')->default(15);
            $table->decimal('approved_min_stock', 14, 3)->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_forecast_settings');
    }
};
