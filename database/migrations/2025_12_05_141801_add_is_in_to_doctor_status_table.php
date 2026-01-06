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
        Schema::table('doctor_status', function (Blueprint $table) {
            if (!Schema::hasColumn('doctor_status', 'is_in')) {
                $table->boolean('is_in')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_status', function (Blueprint $table) {
            //
        });
    }
};
