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
        Schema::table('physical_exams', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['general_appearance', 'head_neck', 'chest_lungs', 'heart_cardiovascular', 'abdomen', 'extremities', 'additional_notes']);
            
            // Add new columns
            $table->text('head')->nullable();
            $table->boolean('conjunctiva_pale')->default(false);
            $table->boolean('thorax_abnormal_cardiac')->default(false);
            $table->boolean('thorax_abnormal_respiratory')->default(false);
            $table->boolean('abdomen_soft')->default(false);
            $table->boolean('abdomen_tender')->default(false);
            $table->boolean('extremities_edema')->default(false);
            $table->boolean('extremities_deformity')->default(false);
            $table->boolean('skin_normal')->default(false);
            $table->text('skin_lesions')->nullable();
            $table->boolean('neurological_normal')->default(false);
            $table->text('neurological_abnormal')->nullable();
            $table->boolean('genitourinary_normal')->default(false);
            $table->text('genitourinary_abnormal')->nullable();
            $table->boolean('heent_normal')->default(false);
            $table->text('heent_abnormal')->nullable();
            $table->boolean('cardiovascular_normal')->default(false);
            $table->text('cardiovascular_abnormal')->nullable();
            $table->boolean('respiratory_normal')->default(false);
            $table->text('respiratory_abnormal')->nullable();
            $table->boolean('musculoskeletal_normal')->default(false);
            $table->text('musculoskeletal_abnormal')->nullable();
            $table->string('administered_by')->nullable();
            $table->text('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('physical_exams', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'head', 'conjunctiva_pale', 'thorax_abnormal_cardiac', 'thorax_abnormal_respiratory',
                'abdomen_soft', 'abdomen_tender', 'extremities_edema', 'extremities_deformity',
                'skin_normal', 'skin_lesions', 'neurological_normal', 'neurological_abnormal',
                'genitourinary_normal', 'genitourinary_abnormal', 'heent_normal', 'heent_abnormal',
                'cardiovascular_normal', 'cardiovascular_abnormal', 'respiratory_normal', 'respiratory_abnormal',
                'musculoskeletal_normal', 'musculoskeletal_abnormal', 'administered_by', 'remarks'
            ]);
            
            // Add back old columns
            $table->text('general_appearance')->nullable();
            $table->text('head_neck')->nullable();
            $table->text('chest_lungs')->nullable();
            $table->text('heart_cardiovascular')->nullable();
            $table->text('abdomen')->nullable();
            $table->text('extremities')->nullable();
            $table->text('additional_notes')->nullable();
        });
    }
};
