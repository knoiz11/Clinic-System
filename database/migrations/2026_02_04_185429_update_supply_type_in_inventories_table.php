<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('inventories')
            ->where('supply_type', 'Clinic')
            ->update(['supply_type' => 'Meds']);

        DB::table('inventories')
            ->where('supply_type', 'Office')
            ->update(['supply_type' => 'Non-Meds']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('inventories')
            ->where('supply_type', 'Meds')
            ->update(['supply_type' => 'Clinic']);

        DB::table('inventories')
            ->where('supply_type', 'Non-Meds')
            ->update(['supply_type' => 'Office']);
    }
};