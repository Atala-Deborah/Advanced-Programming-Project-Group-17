<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('outcomes', function (Blueprint $table) {
            $table->id('OutcomeId');
            $table->unsignedBigInteger('ProjectId');
            $table->string('Title');
            $table->text('Description');
            $table->string('ArtifactLink')->nullable();
            $table->enum('OutcomeType', ['CAD', 'PCB', 'Prototype', 'Report', 'Business Plan']);
            $table->string('QualityCertification')->nullable();
            $table->enum('CommercializationStatus', ['Demoed', 'Market Linked', 'Launched']);
            $table->timestamps();

            $table->foreign('ProjectId')
                  ->references('ProjectId')
                  ->on('projects')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outcomes');
    }
};
