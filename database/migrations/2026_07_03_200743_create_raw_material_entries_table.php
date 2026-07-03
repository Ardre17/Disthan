<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_material_entries', function (Blueprint $table) {

            $table->id();

            $table->foreignId('raw_material_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('supplier');

            $table->decimal('quantity',12,2);

            $table->text('observation')->nullable();

            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raw_material_entries');
    }
};