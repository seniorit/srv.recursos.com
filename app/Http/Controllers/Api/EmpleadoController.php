<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use Illuminate\Http\JsonResponse;

class EmpleadoController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Empleado::with(['empresa', 'usuario'])->get());
    }

    public function show(Empleado $empleado): JsonResponse
    {
        return response()->json($empleado->load(['empresa', 'usuario']));
    }
}
