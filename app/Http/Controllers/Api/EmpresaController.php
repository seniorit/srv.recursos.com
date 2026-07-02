<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\Empresa;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\HttpHandler\StatusHttp;
use App\Exceptions\ControllerHandler;
use App\Http\HttpHandler\ResponseHttp;
use App\Http\Requests\Empresa\CreateRequest;
use App\Http\Requests\Empresa\UpdateRequest;

class EmpresaController extends Controller
{
  public function index(): JsonResponse
  {
    return $this->getAll();
  }

  public function show(string $id): JsonResponse
  {
    return $this->getId($id);
  }

  public function getAll(): JsonResponse
  {
    try {
      $arrData = Empresa::orderBy('nombre_comercial', 'asc')->get();
      return ResponseHttp::responseJson($arrData);
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }

  public function getId(string $id): JsonResponse
  {
    try {
      $arrData = Empresa::findOrFail($id);
      return ResponseHttp::responseJson($arrData);
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }

  public function create(CreateRequest $request): JsonResponse
  {
    try {
      $arrData = Empresa::create($request->validated());
      return ResponseHttp::statusData(
        msg: 'Registro Ingresado Exitosamente',
        statusCode: StatusHttp::HTTP_CREATED,
        data: $arrData
      );
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }

  public function update(UpdateRequest $request): JsonResponse
  {
    try {
      $arrData = Empresa::findOrFail($request->id);
      $arrData->update($request->validated());

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
      $data = Empresa::findOrFail($id);
      $data->delete();

      return ResponseHttp::statusData(
        msg: 'Registro Eliminado Exitosamente',
        data: $data
      );
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }
}
