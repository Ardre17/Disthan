
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reconciliaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150)->nullable();
            $table->string('archivo_origen')->nullable();
            $table->date('fecha_desde')->nullable();
            $table->date('fecha_hasta')->nullable();
            $table->string('estado', 30)->default('pendiente');
            $table->unsignedInteger('total_movimientos')->default(0);
            $table->unsignedInteger('total_coincidencias')->default(0);
            $table->unsignedInteger('total_diferencias')->default(0);
            $table->unsignedInteger('total_pendientes')->default(0);
            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('reconciliacion_movimientos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reconciliacion_id')
                ->constrained('reconciliaciones')
                ->cascadeOnDelete();

            $table->unsignedInteger('numero_fila')->nullable();
            $table->string('razon_social')->nullable();
            $table->date('fecha_movimiento')->nullable();
            $table->decimal('ingresos', 14, 3)->default(0);
            $table->decimal('salidas', 14, 3)->default(0);

            // Conserva todos los campos adicionales del CSV,
            // excepto el RUC, dentro de un objeto JSON.
            $table->json('datos_adicionales')->nullable();

            $table->string('estado_conciliacion', 30)
                ->default('pendiente');

            $table->unsignedBigInteger('movimiento_kardex_id')->nullable();
            $table->text('observacion')->nullable();

            $table->timestamps();

            $table->index(
                ['reconciliacion_id', 'estado_conciliacion'],
                'recon_mov_estado_idx'
            );

            $table->index(
                ['fecha_movimiento', 'razon_social'],
                'recon_mov_fecha_razon_idx'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reconciliacion_movimientos');
        Schema::dropIfExists('reconciliaciones');
    }
};
