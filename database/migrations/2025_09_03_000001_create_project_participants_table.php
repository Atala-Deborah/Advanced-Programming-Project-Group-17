<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_participants', function (Blueprint $table) {
            $table->unsignedBigInteger('ProjectId');
            $table->unsignedBigInteger('ParticipantId');
            $table->enum('RoleOnProject', ['Student', 'Lecturer', 'Contributor']);
            $table->enum('SkillRole', ['Developer', 'Engineer', 'Designer', 'Business Lead']);
            $table->timestamps();
            
            $table->primary(['ProjectId', 'ParticipantId']);

            $table->foreign('ProjectId')->references('ProjectId')->on('projects')->onDelete('cascade');
            $table->foreign('ParticipantId')->references('ParticipantId')->on('participants')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_participants');
    }
};
