<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('inventories', function (Blueprint $table) {

        $table->string('idioma')->nullable();
        $table->string('tipo_precinto')->nullable();
        $table->string('color')->nullable();

    });
}

public function down()
{
    Schema::table('inventories', function (Blueprint $table) {

        $table->dropColumn(['idioma','tipo_precinto','color']);

    });
}
};
