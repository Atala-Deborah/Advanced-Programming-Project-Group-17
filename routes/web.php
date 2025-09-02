<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EquipmentController;

// Resource route for Service
Route::resource('services', ServiceController::class);

// Resource route for Equipment
Route::resource('equipment', EquipmentController::class);
Route::get('facility/{facilityId}/equipment', [EquipmentController::class, 'facilityEquipment'])->name('equipment.facility');