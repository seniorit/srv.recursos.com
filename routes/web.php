<?php

use App\Http\Controllers\Api\AsistenciaController;
use App\Http\Controllers\Api\EmpleadoController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\NominaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::get('/empresas', [EmpresaController::class, 'index']);
    Route::get('/empresas/{empresa}', [EmpresaController::class, 'show']);

    Route::get('/empleados', [EmpleadoController::class, 'index']);
    Route::get('/empleados/{empleado}', [EmpleadoController::class, 'show']);

    Route::get('/asistencias', [AsistenciaController::class, 'index']);
    Route::get('/asistencias/{asistencia}', [AsistenciaController::class, 'show']);

    Route::get('/nominas/historicos', [NominaController::class, 'historicos']);
    Route::get('/nominas/recibos', [NominaController::class, 'recibos']);
});
