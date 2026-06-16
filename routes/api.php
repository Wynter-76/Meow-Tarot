<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PackageApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\ProfileApiController;
use App\Http\Controllers\Api\BookingApiController;

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

// --- Profile (customer & reader) ---
Route::get('profile', [ProfileApiController::class, 'show']);
Route::post('profile/update', [ProfileApiController::class, 'update']);

// --- Bookings ---
Route::get('bookings', [BookingApiController::class, 'index']);
Route::post('bookings', [BookingApiController::class, 'store']);
Route::put('bookings/{id}/cancel', [BookingApiController::class, 'cancel']);
Route::get('readers', [BookingApiController::class, 'readers']);

// --- Users ---
Route::get('users', [UserApiController::class, 'index']);
Route::get('users/{id}', [UserApiController::class, 'show']);
Route::post('users', [UserApiController::class, 'store']);
Route::put('users/{id}', [UserApiController::class, 'update']);
Route::delete('users/{id}', [UserApiController::class, 'destroy']);
