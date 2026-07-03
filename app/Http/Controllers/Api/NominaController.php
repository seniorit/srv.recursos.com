<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\NominaService;
use App\Exceptions\ControllerHandler;
use App\Http\HttpHandler\ResponseHttp;

class NominaController extends Controller
{
  public function __construct(private readonly NominaService $nominaService) {}

  public function historicos(): JsonResponse
  {
    try {
      $arrData = $this->nominaService->historicos();

      return ResponseHttp::responseJson($arrData);
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }

  public function recibos(): JsonResponse
  {
    try {
      $arrData = $this->nominaService->recibos();

      return ResponseHttp::responseJson($arrData);
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }

  public function dashboardStats(): JsonResponse
  {
    try {
      $stats = $this->nominaService->dashboardStats();

      return ResponseHttp::responseJson($stats);
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }
}
