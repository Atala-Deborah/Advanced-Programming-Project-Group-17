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
    Schema::table('projects', function (Blueprint $table) {
        $table->unsignedBigInteger('EquipmentId')->nullable();

        // Optional: add foreign key constraint
        $table->foreign('EquipmentId')->references('EquipmentId')->on('equipment')->onDelete('restrict');
    });
}

public function down()
{
    Schema::table('projects', function (Blueprint $table) {
        $table->dropForeign(['EquipmentId']);
        $table->dropColumn('EquipmentId');
    });
}
};
