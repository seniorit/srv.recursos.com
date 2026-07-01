<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use Illuminate\Http\JsonResponse;

class AsistenciaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Asistencia::with('empleado')->get());
    }

    public function show(Asistencia $asistencia): JsonResponse
    {
        return response()->json($asistencia->load('empleado'));
    }
}
