<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mobile_order_preparations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_detail_id')->unique();
            $table->decimal('prepared_quantity', 12, 3)->default(0);
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->index('order_detail_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobile_order_preparations');
    }
};
