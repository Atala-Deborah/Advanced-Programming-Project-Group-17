<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id('ProgramId');
            $table->string('Name');
            $table->text('Description')->nullable();
            $table->string('NationalAlignment')->nullable();
            $table->string('FocusAreas')->nullable();
            $table->enum('Phases', [
                'Cross-Skilling',
                'Collaboration',
                'Technical Skills',
                'Prototyping',
                'Commercialization'
            ])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
