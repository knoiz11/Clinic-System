<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->boolean('is_otc')->default(false)->after('supply_type')->comment('Over The Counter');
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn('is_otc');
        });
    }
};
