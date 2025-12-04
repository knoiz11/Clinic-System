<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_status', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_in')->default(false);
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        DB::table('doctor_status')->insert([
            'is_in' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_status');
    }
};