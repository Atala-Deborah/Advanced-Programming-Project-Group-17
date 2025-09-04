<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id('ProjectId');
            $table->unsignedBigInteger('ProgramId')->nullable(); // Making it nullable for now as it's not in the form
            $table->unsignedBigInteger('FacilityId');
            $table->string('Title');
            $table->enum('Status', ['Planning', 'Active', 'Completed', 'On Hold']);
            $table->enum('NatureOfProject', ['Research', 'Prototype', 'Applied work'])->default('Research');
            $table->text('Description');
            $table->string('InnovationFocus')->nullable();
            $table->enum('PrototypeStage', ['Concept', 'Prototype', 'MVP', 'Market Launch'])->default('Concept');
            $table->date('StartDate');
            $table->date('EndDate')->nullable();
            $table->text('TestingRequirements')->nullable();
            $table->text('CommercializationPlan')->nullable();
            $table->timestamps();
            
            $table->foreign('FacilityId')
                  ->references('FacilityId')
                  ->on('facilities')
                  ->onDelete('restrict');
                  
            $table->foreign('ProgramId')
                  ->references('ProgramId')
                  ->on('programs')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
