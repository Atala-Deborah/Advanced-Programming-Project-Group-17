<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id('ParticipantId');
            $table->string('FullName');
            $table->string('Email')->unique();
            $table->enum('Affiliation', ['CS', 'SE', 'Engineering', 'Other']);
            $table->enum('Specialization', ['Software', 'Hardware', 'Business']);
            $table->boolean('CrossSkillTrained')->default(false);
            $table->enum('Institution', ['SCIT', 'CEDAT', 'UniPod', 'UIRI', 'Lwera', 'Other']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
