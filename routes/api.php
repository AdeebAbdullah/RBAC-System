<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\HealthController;

    Route::get('/health', [HealthController::class, 'check']);

    Route::middleware(['auth.user', 'permission:read:article'])->get('/articles', [ArticleController::class, 'index']);

    Route::middleware(['auth.user', 'permission:create:article'])->post('/articles', [ArticleController::class, 'store']);

    Route::middleware(['auth.user', 'permission:delete:article'])->delete('/articles/{id}', [ArticleController::class, 'destroy']);

    //Get/me
    Route::middleware('auth.user')->get('/me', [MeController::class, 'me']);