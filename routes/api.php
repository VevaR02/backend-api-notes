<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/users/me', [AuthController::class, 'me']);
        
        Route::post('/notes', [NoteController::class, 'store']);
        Route::get('/notes', [NoteController::class, 'index']);
        Route::get('/notes/archived', [NoteController::class, 'archived']);
        Route::get('/notes/{id}', [NoteController::class, 'show']);
        
        Route::post('/notes/{id}/archive', [NoteController::class, 'archiveNote']);
        Route::post('/notes/{id}/unarchive', [NoteController::class, 'unarchiveNote']);
        Route::delete('/notes/{id}', [NoteController::class, 'destroy']);
    });
});