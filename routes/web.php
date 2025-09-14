<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectParticipantController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\OutcomeController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Projects
Route::resource('projects', ProjectController::class);

// Project Participants
Route::post('/projects/{project}/participants', [ProjectParticipantController::class, 'store'])->name('project.participants.store');
Route::delete('/projects/{project}/participants/{participant}', [ProjectParticipantController::class, 'destroy'])->name('project.participants.destroy');

// Equipment
Route::resource('equipment', EquipmentController::class);
Route::get('facility/{facilityId}/equipment', [EquipmentController::class, 'facilityEquipment'])->name('equipment.facility');
Route::post('/projects/{project}/equipment/{equipment}', [ProjectController::class, 'attachEquipment'])->name('projects.equipment.attach');
Route::delete('/projects/{project}/equipment/{equipment}', [ProjectController::class, 'detachEquipment'])->name('projects.equipment.detach');

// Facilities
Route::get('/facilities/{facility}/delete', [FacilityController::class, 'confirmDelete'])->name('facilities.delete-confirm');
Route::resource('facilities', FacilityController::class);

// Services
Route::resource('services', ServiceController::class);

// Programs
Route::resource('programs', ProgramController::class);

// Participants Routes
Route::resource('participants', ParticipantController::class);

// Outcomes Routes
Route::resource('outcomes', OutcomeController::class);

// Redirect /home to dashboard
Route::get('/home', function() {
    return redirect()->route('dashboard');
});
