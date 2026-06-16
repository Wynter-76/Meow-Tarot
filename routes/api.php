<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PackageApiController;
use App\Http\Controllers\Api\AuthApiController;

// Endpoint untuk aplikasi mobile (tanpa session/CSRF).
// Prefix "/api" otomatis ditambahkan oleh Laravel.

// --- Auth ---
Route::post('login', [AuthApiController::class, 'login']);

// --- Packages ---
Route::get('packages', [PackageApiController::class, 'index']);
Route::get('packages/{id}', [PackageApiController::class, 'show']);
Route::post('packages', [PackageApiController::class, 'store']);
Route::put('packages/{id}', [PackageApiController::class, 'update']);
Route::delete('packages/{id}', [PackageApiController::class, 'destroy']);
