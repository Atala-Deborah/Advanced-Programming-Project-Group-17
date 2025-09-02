<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id('EquipmentId');
            $table->unsignedBigInteger('FacilityId');
            $table->string('Name');
            $table->text('Capabilities')->nullable();
            $table->text('Description')->nullable();
            $table->string('InventoryCode')->unique();
            $table->string('UsageDomain'); // Electronics, Mechanical, IoT
            $table->string('SupportPhase'); // Training, Prototyping, etc.
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('FacilityId')->references('FacilityId')->on('facilities')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
