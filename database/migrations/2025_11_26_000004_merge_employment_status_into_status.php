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
        Schema::table('employees', function (Blueprint $table) {
            // Add backup column to preserve employment_status on rollback
            if (!Schema::hasColumn('employees', 'employment_status_backup')) {
                $table->string('employment_status_backup')->nullable()->after('employment_status');
            }
        });

        // Copy employment_status to backup and merge into status when appropriate
        DB::table('employees')->get()->each(function ($emp) {
            $employmentStatus = trim($emp->employment_status ?? '');
            if ($employmentStatus !== '') {
                // Back it up
                DB::table('employees')->where('id', $emp->id)->update(['employment_status_backup' => $employmentStatus]);

                // If status is empty or equals 'Inactive', set it to employment status value
                if (empty($emp->status) || strtolower($emp->status) === 'inactive') {
                    DB::table('employees')->where('id', $emp->id)->update(['status' => $employmentStatus]);
                }
            }
        });

        // Drop employment_status column now that it's backed up and merged
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'employment_status')) {
                $table->dropColumn('employment_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'employment_status')) {
                $table->string('employment_status')->nullable()->after('status');
            }
        });

        // Restore from backup
        DB::table('employees')->get()->each(function ($emp) {
            if (!empty($emp->employment_status_backup)) {
                DB::table('employees')->where('id', $emp->id)->update(['employment_status' => $emp->employment_status_backup]);
            }
        });

        // Drop backup column
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'employment_status_backup')) {
                $table->dropColumn('employment_status_backup');
            }
        });
    }
};
