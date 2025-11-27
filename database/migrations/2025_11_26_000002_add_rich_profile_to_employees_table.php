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
            // Add profile fields
            $table->string('employee_id')->nullable()->unique();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('sex')->nullable();
            $table->date('birthdate')->nullable();
            $table->integer('age')->nullable();
            $table->string('religion')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('philhealth_no')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('division')->nullable();
            $table->string('contact_no')->nullable();
            $table->text('notes')->nullable();
        });

        // Try to split existing 'name' into first_name / last_name for existing rows
        try {
            DB::table('employees')->get()->each(function ($emp) {
                $name = trim($emp->name ?? '');
                $first = $name;
                $last = null;
                $middle = null;
                if ($name && mb_strpos($name, ' ') !== false) {
                    // naive split: last word is last name
                    $parts = preg_split('/\s+/', $name);
                    $last = array_pop($parts);
                    $first = array_shift($parts) ?? $first;
                    $middle = count($parts) ? implode(' ', $parts) : null;
                }
                DB::table('employees')->where('id', $emp->id)->update([
                    'first_name' => $first,
                    'middle_name' => $middle,
                    'last_name' => $last,
                    'contact_no' => $emp->contact,
                ]);
            });
        } catch (\Exception $e) {
            // ignore
        }

        // After migrating data, drop the legacy name column
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'name')) {
                $table->dropColumn('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add name column and populate from first/last/middle
        Schema::table('employees', function (Blueprint $table) {
            $table->string('name')->nullable();
        });

        try {
            DB::table('employees')->get()->each(function ($emp) {
                $parts = array_filter([$emp->first_name, $emp->middle_name, $emp->last_name]);
                $full = implode(' ', $parts);
                DB::table('employees')->where('id', $emp->id)->update(['name' => $full]);
            });
        } catch (\Exception $e) {
            // ignore
        }

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'employee_id', 'last_name', 'first_name', 'middle_name', 'sex', 'birthdate', 'age', 'religion', 'blood_type', 'philhealth_no', 'employment_status', 'division', 'contact_no', 'notes'
            ]);
        });
    }
};
