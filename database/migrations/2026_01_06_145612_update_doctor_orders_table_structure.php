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
            // Drop old columns
            $table->dropColumn(['medication_orders', 'lab_tests_ordered', 'special_instructions']);
            
            // Add new columns
            $table->text('doctors_order')->nullable();
            $table->text('prescription')->nullable();
            $table->text('diagnosis')->nullable();
            $table->string('icd_10_code')->nullable();
            $table->string('icd_11_code')->nullable();
            $table->string('disposition')->nullable();
            $table->date('order_date')->nullable();
            $table->string('administered_by')->nullable();
            $table->text('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_orders', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'doctors_order', 'prescription', 'diagnosis', 'icd_10_code', 'icd_11_code',
                'disposition', 'order_date', 'administered_by', 'remarks'
            ]);
            
            // Add back old columns
            $table->text('medication_orders')->nullable();
            $table->text('lab_tests_ordered')->nullable();
            $table->text('special_instructions')->nullable();
        });
    }
};
