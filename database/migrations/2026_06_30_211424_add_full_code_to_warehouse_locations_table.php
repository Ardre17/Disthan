<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warehouse_locations', function (Blueprint $table) {

            $table->string('full_code')
                  ->unique()
                  ->after('code');

        });
    }

    public function down(): void
    {
        Schema::table('warehouse_locations', function (Blueprint $table) {

            $table->dropColumn('full_code');

        });
    }
};