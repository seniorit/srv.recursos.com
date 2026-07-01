<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\JsonResponse;

class EmpresaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Empresa::with('empleados')->get());
    }

    public function show(Empresa $empresa): JsonResponse
    {
        return response()->json($empresa->load('empleados'));
    }
}
