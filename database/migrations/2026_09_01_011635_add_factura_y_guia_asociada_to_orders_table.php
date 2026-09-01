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
    Schema::table('orders', function (Blueprint $table) {

        $table->string('factura_asociada')
            ->nullable()
            ->after('numero_orden');

        $table->string('guia_asociada')
            ->nullable()
            ->after('factura_asociada');

    });
}

    public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {

        $table->dropColumn([
            'factura_asociada',
            'guia_asociada',
        ]);

    });
}
};
