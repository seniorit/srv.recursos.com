<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NominaController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\EmpleadoController;
use App\Http\Controllers\Api\AsistenciaController;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/logout', [AuthController::class, 'logout']);
Route::get('auth/me', [AuthController::class, 'me']);

Route::apiResource('empleados', EmpleadoController::class);
Route::apiResource('empresas', EmpresaController::class);
Route::apiResource('asistencias', AsistenciaController::class);
Route::get('dashboard/stats', [NominaController::class, 'dashboardStats']);
Route::get('nominas/historicos', [NominaController::class, 'historicos']);
Route::get('nominas/recibos', [NominaController::class, 'recibos']);
