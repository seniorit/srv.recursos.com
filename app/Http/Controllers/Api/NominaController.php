<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HistoricoNomina;
use App\Models\ReciboNomina;
use Illuminate\Http\JsonResponse;

class NominaController extends Controller
{
    public function historicos(): JsonResponse
    {
        return response()->json(HistoricoNomina::with(['empresa', 'recibosNominas'])->get());
    }

    public function recibos(): JsonResponse
    {
        return response()->json(ReciboNomina::with(['historicoNomina', 'empleado'])->get());
    }
}
