<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmpleadoController;

Route::group([
  'prefix' => 'empleado'
], function () {
  Route::get('getall', [EmpleadoController::class, 'getall']);
  Route::get('getId/{id}', [EmpleadoController::class, 'getId']);
  Route::post('create', [EmpleadoController::class, 'create']);
  Route::put('update', [EmpleadoController::class, 'update']);
  Route::delete('destroy/{id}', [EmpleadoController::class, 'destroy']);
});
