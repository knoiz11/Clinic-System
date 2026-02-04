<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('object_id')->unique()->nullable(); // e.g. C-001
            $table->date('date_purchased')->nullable();
            $table->string('supply_type')->nullable(); // Meds / Non-Meds
            $table->string('item_name');
            $table->integer('quantity')->default(0);
            $table->string('unit')->nullable(); // tablets, units, bottles
            $table->decimal('price', 12, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};