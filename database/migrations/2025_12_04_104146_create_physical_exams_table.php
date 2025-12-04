<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('physical_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->text('general_appearance')->nullable();
            $table->text('head_neck')->nullable();
            $table->text('chest_lungs')->nullable();
            $table->text('heart_cardiovascular')->nullable();
            $table->text('abdomen')->nullable();
            $table->text('extremities')->nullable();
            $table->text('additional_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('physical_exams');
    }
};