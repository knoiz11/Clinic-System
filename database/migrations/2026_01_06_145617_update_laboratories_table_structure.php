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
        Schema::table('laboratories', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['test_type', 'test_results', 'test_date', 'conducted_by']);
            
            // Add new columns
            $table->text('blood_chemistry')->nullable();
            $table->text('blood_oxygenation')->nullable();
            $table->text('complete_blood_count')->nullable();
            $table->text('immunology')->nullable();
            $table->text('clinical_chemistry')->nullable();
            $table->text('fecalysis')->nullable();
            $table->text('serology')->nullable();
            $table->text('sputum_microscopy')->nullable();
            $table->text('urinalysis')->nullable();
            $table->text('hematology')->nullable();
            $table->string('administered_by')->nullable();
            $table->text('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laboratories', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'blood_chemistry', 'blood_oxygenation', 'complete_blood_count', 'immunology',
                'clinical_chemistry', 'fecalysis', 'serology', 'sputum_microscopy', 'urinalysis',
                'hematology', 'administered_by', 'remarks'
            ]);
            
            // Add back old columns
            $table->string('test_type')->nullable();
            $table->text('test_results')->nullable();
            $table->date('test_date')->nullable();
            $table->string('conducted_by')->nullable();
        });
    }
};
