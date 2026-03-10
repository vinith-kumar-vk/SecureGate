<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisitorController;

Route::post('/register', [VisitorController::class, 'register']);
Route::get('/request/{id}', [VisitorController::class, 'getRequest']);
Route::get('/status/{id}', [VisitorController::class, 'getStatus']);
Route::post('/approve/{id}', [VisitorController::class, 'approve']);
Route::post('/reject/{id}', [VisitorController::class, 'reject']);
Route::get('/visitors', [VisitorController::class, 'getAll']);
