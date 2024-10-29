<?php

use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CorsMiddleware;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware([CorsMiddleware::class])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles/create', [RoleController::class, 'store']);
    Route::get('/roles/{id}', [RoleController::class, 'show']);
    Route::put('/roles/{id}/update', [RoleController::class, 'update']);
    Route::post('/roles/{id}/delete', [RoleController::class, 'destroy']);
    
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/create', [UserController::class, 'store']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}/update', [UserController::class, 'update']);
    Route::post('/users/{id}/delete', [UserController::class, 'destroy']);
    
    Route::get('/audit-trails', [AuditTrailController::class, 'index']);
});