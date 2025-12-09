<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing users with 'user' role to 'nurse' (or keep as needed)
        DB::table('users')->where('role', 'user')->update(['role' => 'nurse']);
        
        // The role column already exists, we just need to ensure it accepts our new roles
        // Valid roles: 'admin', 'doctor', 'nurse'
    }

    public function down(): void
    {
        // Revert nurse back to user
        DB::table('users')->where('role', 'nurse')->update(['role' => 'user']);
    }
};