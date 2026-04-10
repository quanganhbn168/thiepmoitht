<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReunionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ====================================
// PUBLIC ROUTES (No Auth Required)
// ====================================

// Demo reunion pages
Route::get('/hop-lop-nien-khoa-1998-2001-que-vo-1', [ReunionController::class, 'showQueVoDemo'])->name('reunion.demo.que-vo');
Route::get('/hop-lop-que-vo-1-teacher', [ReunionController::class, 'showQueVoTeacherDemo'])->name('reunion.demo.que-vo-teacher');
Route::get('/hop-lop-que-vo-2', [ReunionController::class, 'showQueVo2Demo'])->name('reunion.demo.que-vo-2');
Route::post('/demo-hop-lop-rsvp', [ReunionController::class, 'storeRsvpDemo'])->name('reunion.demo.rsvp');
Route::post('/demo-hop-lop-message', [ReunionController::class, 'storeMessageDemo'])->name('reunion.demo.message');

// Fallback: /{slug} can be reunion
Route::get('/{slug}', [\App\Http\Controllers\HomeController::class, 'resolveSlug'])
    ->where('slug', '^(?!admin|dashboard|login|register|profile|payment|api).*$')
    ->name('resolve.slug');
