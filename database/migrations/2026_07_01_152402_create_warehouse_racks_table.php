<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouse_racks', function (Blueprint $table) {

            $table->id();

            // Rack
            $table->string('rack');

            // Nivel
            $table->tinyInteger('level');

            // Nombre visible
            $table->string('name');

            // Filas
            $table->tinyInteger('rows');

            // Columnas
            $table->tinyInteger('columns');

            // Tipo
            $table->enum('type',[
                'ALMACENAMIENTO',
                'BAJA_ROTACION',
                'CUARENTENA',
                'PRODUCCION',
                'DEVOLUCIONES'
            ])->default('ALMACENAMIENTO');

            // Color del rack
            $table->string('color')->default('#4F8EF7');

            // Activo
            $table->boolean('active')->default(true);

            // Observaciones
            $table->text('notes')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouse_racks');
    }
};
