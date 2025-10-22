<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('equipment', function (Blueprint $table) {
        $table->json('SupportPhases')->nullable();
    });
}

public function down()
{
    Schema::table('equipment', function (Blueprint $table) {
        $table->dropColumn('SupportPhases');
    });
}
};
