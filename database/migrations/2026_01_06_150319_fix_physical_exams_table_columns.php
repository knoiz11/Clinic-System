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
            // Check and drop columns that exist
            if (Schema::hasColumn('physical_exams', 'thorax_abnormal_respiratory')) {
                $table->dropColumn('thorax_abnormal_respiratory');
            }
            if (Schema::hasColumn('physical_exams', 'abdomen_soft')) {
                $table->dropColumn('abdomen_soft');
            }
            if (Schema::hasColumn('physical_exams', 'abdomen_tender')) {
                $table->dropColumn('abdomen_tender');
            }
            if (Schema::hasColumn('physical_exams', 'extremities_edema')) {
                $table->dropColumn('extremities_edema');
            }
            if (Schema::hasColumn('physical_exams', 'extremities_deformity')) {
                $table->dropColumn('extremities_deformity');
            }
            if (Schema::hasColumn('physical_exams', 'skin_normal')) {
                $table->dropColumn('skin_normal');
            }
            if (Schema::hasColumn('physical_exams', 'skin_lesions')) {
                $table->dropColumn('skin_lesions');
            }
            if (Schema::hasColumn('physical_exams', 'neurological_normal')) {
                $table->dropColumn('neurological_normal');
            }
            if (Schema::hasColumn('physical_exams', 'neurological_abnormal')) {
                $table->dropColumn('neurological_abnormal');
            }
            if (Schema::hasColumn('physical_exams', 'genitourinary_normal')) {
                $table->dropColumn('genitourinary_normal');
            }
            if (Schema::hasColumn('physical_exams', 'genitourinary_abnormal')) {
                $table->dropColumn('genitourinary_abnormal');
            }
            if (Schema::hasColumn('physical_exams', 'heent_normal')) {
                $table->dropColumn('heent_normal');
            }
            if (Schema::hasColumn('physical_exams', 'heent_abnormal')) {
                $table->dropColumn('heent_abnormal');
            }
            if (Schema::hasColumn('physical_exams', 'cardiovascular_normal')) {
                $table->dropColumn('cardiovascular_normal');
            }
            if (Schema::hasColumn('physical_exams', 'cardiovascular_abnormal')) {
                $table->dropColumn('cardiovascular_abnormal');
            }
            if (Schema::hasColumn('physical_exams', 'respiratory_normal')) {
                $table->dropColumn('respiratory_normal');
            }
            if (Schema::hasColumn('physical_exams', 'respiratory_abnormal')) {
                $table->dropColumn('respiratory_abnormal');
            }
            if (Schema::hasColumn('physical_exams', 'musculoskeletal_normal')) {
                $table->dropColumn('musculoskeletal_normal');
            }
            if (Schema::hasColumn('physical_exams', 'musculoskeletal_abnormal')) {
                $table->dropColumn('musculoskeletal_abnormal');
            }
        });

        Schema::table('physical_exams', function (Blueprint $table) {
            // Add columns only if they don't exist
            if (!Schema::hasColumn('physical_exams', 'conjunctiva_yellowish')) {
                $table->boolean('conjunctiva_yellowish')->default(false);
            }
            if (!Schema::hasColumn('physical_exams', 'conjunctiva_remarks')) {
                $table->text('conjunctiva_remarks')->nullable();
            }
            if (!Schema::hasColumn('physical_exams', 'neck_enlarged_thyroid')) {
                $table->boolean('neck_enlarged_thyroid')->default(false);
            }
            if (!Schema::hasColumn('physical_exams', 'neck_enlarged_lymph')) {
                $table->boolean('neck_enlarged_lymph')->default(false);
            }
            if (!Schema::hasColumn('physical_exams', 'thorax_abnormal_cardiac')) {
                $table->boolean('thorax_abnormal_cardiac')->default(false);
            }
            if (!Schema::hasColumn('physical_exams', 'thorax_abnormal_breathing')) {
                $table->boolean('thorax_abnormal_breathing')->default(false);
            }
            if (!Schema::hasColumn('physical_exams', 'thorax_remarks')) {
                $table->text('thorax_remarks')->nullable();
            }
            if (!Schema::hasColumn('physical_exams', 'chest')) {
                $table->text('chest')->nullable();
            }
            if (!Schema::hasColumn('physical_exams', 'breast_mass')) {
                $table->boolean('breast_mass')->default(false);
            }
            if (!Schema::hasColumn('physical_exams', 'breast_nipple_discharge')) {
                $table->boolean('breast_nipple_discharge')->default(false);
            }
            if (!Schema::hasColumn('physical_exams', 'breast_skin_orange')) {
                $table->boolean('breast_skin_orange')->default(false);
            }
            if (!Schema::hasColumn('physical_exams', 'breast_enlarged_nodes')) {
                $table->boolean('breast_enlarged_nodes')->default(false);
            }
            if (!Schema::hasColumn('physical_exams', 'breast_remarks')) {
                $table->text('breast_remarks')->nullable();
            }
            if (!Schema::hasColumn('physical_exams', 'abdomen_enlarged_liver')) {
                $table->boolean('abdomen_enlarged_liver')->default(false);
            }
            if (!Schema::hasColumn('physical_exams', 'abdomen_mass')) {
                $table->boolean('abdomen_mass')->default(false);
            }
            if (!Schema::hasColumn('physical_exams', 'abdomen_scar')) {
                $table->boolean('abdomen_scar')->default(false);
            }
            if (!Schema::hasColumn('physical_exams', 'abdomen_tenderness')) {
                $table->boolean('abdomen_tenderness')->default(false);
            }
            if (!Schema::hasColumn('physical_exams', 'abdomen_remarks')) {
                $table->text('abdomen_remarks')->nullable();
            }
            if (!Schema::hasColumn('physical_exams', 'others')) {
                $table->text('others')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('physical_exams', function (Blueprint $table) {
            // Drop correct columns
            $columns = [
                'conjunctiva_yellowish', 'conjunctiva_remarks', 'neck_enlarged_thyroid', 
                'neck_enlarged_lymph', 'thorax_abnormal_cardiac', 'thorax_abnormal_breathing',
                'thorax_remarks', 'chest', 'breast_mass', 'breast_nipple_discharge', 
                'breast_skin_orange', 'breast_enlarged_nodes', 'breast_remarks', 
                'abdomen_enlarged_liver', 'abdomen_mass', 'abdomen_scar', 
                'abdomen_tenderness', 'abdomen_remarks', 'others'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('physical_exams', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};