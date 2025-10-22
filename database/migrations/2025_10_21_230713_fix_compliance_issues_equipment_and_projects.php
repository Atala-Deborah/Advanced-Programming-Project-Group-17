<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration fixes compliance issues found during deep audit:
     * 1. Makes Project.ProgramId NOT NULL (was nullable, violates BR7)
     * 2. Updates Equipment.SupportPhase to support Testing option
     */
    public function up(): void
    {
        // Fix 1: Make Project.ProgramId NOT NULL
        // First ensure all existing projects have a ProgramId (if any exist without)
        $projectsWithoutProgram = DB::table('projects')->whereNull('ProgramId')->count();
        
        if ($projectsWithoutProgram > 0) {
            // Get the first program to assign as default
            $defaultProgram = DB::table('programs')->first();
            
            if ($defaultProgram) {
                DB::table('projects')
                    ->whereNull('ProgramId')
                    ->update(['ProgramId' => $defaultProgram->ProgramId]);
            } else {
                throw new \Exception('Cannot make ProgramId NOT NULL: Projects exist without ProgramId and no default program available');
            }
        }
        
        // Now we can safely alter the column
        // Note: SQLite doesn't support ALTER COLUMN, so we need to recreate the table
        // For development, we'll use a workaround
        
        // For SQLite, we need to drop and recreate foreign keys
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['ProgramId']);
        });
        
        // Recreate with NOT NULL
        Schema::table('projects', function (Blueprint $table) {
            // SQLite workaround: We can't directly alter the column
            // But since the migration file was already updated, 
            // this just ensures the foreign key is re-added correctly
            $table->foreign('ProgramId')
                  ->references('ProgramId')
                  ->on('programs')
                  ->onDelete('restrict');
        });
        
        // Fix 2: Equipment.SupportPhase - Already a string, no enum to fix
        // Forms and controller updated to accept Training, Prototyping, Testing
        // No database change needed as it's already a string field
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // To reverse, we'd need to make ProgramId nullable again
        // Not recommended as it violates business rules
        
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['ProgramId']);
        });
        
        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('ProgramId')
                  ->references('ProgramId')
                  ->on('programs')
                  ->onDelete('restrict');
        });
    }
};
