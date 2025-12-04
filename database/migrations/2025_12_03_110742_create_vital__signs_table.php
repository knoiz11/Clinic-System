<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('body_temperature')->nullable();
            $table->string('heart_rate');
            $table->string('pulse_rate')->nullable();
            $table->string('bp_systolic');
            $table->string('bp_diastolic');
            $table->string('respiratory_rate')->nullable();
            $table->string('bp_assessment');
            $table->string('administered_by');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vital_signs');
    }
};