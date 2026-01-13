<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('doctor_status', function (Blueprint $table) {
            $table->string('updated_by')->nullable()->after('is_in');
        });
    }

    public function down()
    {
        Schema::table('doctor_status', function (Blueprint $table) {
            $table->dropColumn('updated_by');
        });
    }
};