<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\ReciboNomina;
use App\Models\HistoricoNomina;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Exceptions\ControllerHandler;
use App\Http\HttpHandler\ResponseHttp;

class NominaController extends Controller
{
  public function historicos(): JsonResponse
  {
    try {
      $arrData = HistoricoNomina::with('empresa')
        ->orderBy('fecha_generacion', 'desc')
        ->get();

      return ResponseHttp::responseJson($arrData);
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }

  public function recibos(): JsonResponse
  {
    try {
      $arrData = ReciboNomina::with(['empleado', 'historicoNomina'])
        ->orderBy('created_at', 'desc')
        ->get();

      return ResponseHttp::responseJson($arrData);
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }
}
