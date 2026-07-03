<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\HttpHandler\StatusHttp;
use App\Exceptions\ControllerHandler;
use App\Http\HttpHandler\ResponseHttp;
use App\Http\Services\EmpleadoService;
use App\Http\Requests\Empleado\CreateRequest;
use App\Http\Requests\Empleado\UpdateRequest;

class EmpleadoController extends Controller
{
  public function __construct(private readonly EmpleadoService $empleadoService) {}

  public function index(): JsonResponse
  {
    try {
      $arrData = $this->empleadoService->getAll();
      return ResponseHttp::responseJson($arrData);
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }

  public function store(CreateRequest $request): JsonResponse
  {
    try {
      $arrData = $this->empleadoService->create($request->validated());
      return ResponseHttp::statusData(
        msg: 'Registro Ingresado Exitosamente',
        statusCode: StatusHttp::HTTP_CREATED,
        data: $arrData
      );
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }

  public function show(string $id): JsonResponse
  {
    try {
      $arrData = $this->empleadoService->getById($id);

      return ResponseHttp::statusData(
        msg: null,
        data: $arrData
      );
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }

  public function update(UpdateRequest $request, ?string $id = null): JsonResponse
  {
    try {
      $targetId = $id ?? $request->input('id');
      if (blank($targetId)) {
        return ResponseHttp::statusError(
          statusCode: StatusHttp::HTTP_BAD_REQUEST,
          msg: 'El identificador del empleado es requerido.'
        );
      }

      $arrData = $this->empleadoService->update($targetId, $request->validated());

      return ResponseHttp::statusData(
        msg: 'Registro Actualizado exitosamente',
        data: $arrData
      );
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }

  public function destroy(string $id): JsonResponse
  {
    try {
      $data = $this->empleadoService->delete($id);
      return ResponseHttp::statusData(
        msg: 'Registro Eliminado Exitosamente',
        data: $data
      );
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }
}
