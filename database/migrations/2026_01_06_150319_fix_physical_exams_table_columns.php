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
            // Drop wrong columns
            $table->dropColumn([
                'thorax_abnormal_cardiac', 'thorax_abnormal_respiratory', 'abdomen_soft', 'abdomen_tender',
                'extremities_edema', 'extremities_deformity', 'skin_normal', 'skin_lesions',
                'neurological_normal', 'neurological_abnormal', 'genitourinary_normal', 'genitourinary_abnormal',
                'heent_normal', 'heent_abnormal', 'cardiovascular_normal', 'cardiovascular_abnormal',
                'respiratory_normal', 'respiratory_abnormal', 'musculoskeletal_normal', 'musculoskeletal_abnormal'
            ]);
            
            // Add correct columns
            $table->boolean('conjunctiva_yellowish')->default(false);
            $table->text('conjunctiva_remarks')->nullable();
            $table->boolean('neck_enlarged_thyroid')->default(false);
            $table->boolean('neck_enlarged_lymph')->default(false);
            $table->text('thorax_remarks')->nullable();
            $table->text('chest')->nullable();
            $table->boolean('breast_mass')->default(false);
            $table->boolean('breast_nipple_discharge')->default(false);
            $table->boolean('breast_skin_orange')->default(false);
            $table->boolean('breast_enlarged_nodes')->default(false);
            $table->text('breast_remarks')->nullable();
            $table->boolean('abdomen_enlarged_liver')->default(false);
            $table->boolean('abdomen_mass')->default(false);
            $table->boolean('abdomen_scar')->default(false);
            $table->boolean('abdomen_tenderness')->default(false);
            $table->text('abdomen_remarks')->nullable();
            $table->text('others')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('physical_exams', function (Blueprint $table) {
            // Drop correct columns
            $table->dropColumn([
                'conjunctiva_yellowish', 'conjunctiva_remarks', 'neck_enlarged_thyroid', 'neck_enlarged_lymph',
                'thorax_remarks', 'chest', 'breast_mass', 'breast_nipple_discharge', 'breast_skin_orange',
                'breast_enlarged_nodes', 'breast_remarks', 'abdomen_enlarged_liver', 'abdomen_mass',
                'abdomen_scar', 'abdomen_tenderness', 'abdomen_remarks', 'others'
            ]);
            
            // Add back wrong columns
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
        });
    }
};
