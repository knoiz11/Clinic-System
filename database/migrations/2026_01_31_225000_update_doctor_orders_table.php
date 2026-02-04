<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('doctor_orders', function (Blueprint $table) {
            // Add column for ICD-11 title if it doesn't exist
            if (!Schema::hasColumn('doctor_orders', 'icd11_titles')) {
                $table->text('icd11_titles')->nullable()->after('icd11_codes')->comment('ICD-11 code titles');
            }
            // Add column for medications data (JSON)
            if (!Schema::hasColumn('doctor_orders', 'medications_dispensed')) {
                $table->json('medications_dispensed')->nullable()->after('prescription')->comment('Medications dispensed with quantities');
            }
        });
    }

    public function down(): void
    {
        Schema::table('doctor_orders', function (Blueprint $table) {
            $table->dropColumn(['icd11_titles', 'medications_dispensed']);
        });
    }
};
