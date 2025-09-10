<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_equipment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ProjectId');
            $table->unsignedBigInteger('EquipmentId');
            $table->timestamps();

            $table->foreign('ProjectId')->references('ProjectId')->on('projects')->onDelete('cascade');
            $table->foreign('EquipmentId')->references('EquipmentId')->on('equipment')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_equipment');
    }
};
