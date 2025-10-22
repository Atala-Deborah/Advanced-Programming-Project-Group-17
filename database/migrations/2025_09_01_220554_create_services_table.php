<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id('ServiceId'); // Primary key
            $table->unsignedBigInteger('FacilityId'); // Foreign key
            $table->string('Name'); // Service name
            $table->text('Description')->nullable();
            $table->enum('Category', ['Machining', 'Testing', 'Training']);
            $table->enum('SkillType', ['Hardware', 'Software', 'Integration']);
            $table->timestamps();

            // Add foreign key constraint with cascade delete
            $table->foreign('FacilityId')->references('FacilityId')->on('facilities')->onDelete('cascade');

            // Unique constraint for Name within FacilityId
            $table->unique(['FacilityId', 'Name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
