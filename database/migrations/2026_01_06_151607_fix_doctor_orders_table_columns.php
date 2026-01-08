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
        Schema::table('doctor_orders', function (Blueprint $table) {
            // Drop wrong columns
            $table->dropColumn(['icd_10_code', 'icd_11_code', 'administered_by', 'remarks']);
            
            // Add correct columns
            $table->text('other_diagnosis')->nullable();
            $table->string('icd11_codes')->nullable();
            $table->text('treatment_plan')->nullable();
            $table->text('reasons_for_discharge')->nullable();
            $table->datetime('discharge_datetime')->nullable();
            $table->text('order_remarks')->nullable();
            $table->string('schedule_next')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('doctor_orders', function (Blueprint $table) {
            // Drop correct columns
            $table->dropColumn([
                'other_diagnosis', 'icd11_codes', 'treatment_plan', 'reasons_for_discharge',
                'discharge_datetime', 'order_remarks', 'schedule_next'
            ]);
            
            // Add back wrong columns
            $table->string('icd_10_code')->nullable();
            $table->string('icd_11_code')->nullable();
            $table->string('administered_by')->nullable();
            $table->text('remarks')->nullable();
        });
    }
};
