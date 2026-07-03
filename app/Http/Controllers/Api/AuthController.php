<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\HttpHandler\StatusHttp;
use App\Exceptions\ControllerHandler;
use App\Http\HttpHandler\ResponseHttp;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
  public function __construct(private readonly AuthService $authService) {}

  public function register(RegisterRequest $request): JsonResponse
  {
    try {
      $usuario = $this->authService->register($request->validated());
      $token = $this->authService->createToken($usuario);

      return ResponseHttp::statusData(
        msg: 'Registro completado con éxito',
        data: [
          'user' => $usuario,
          'token' => $token,
        ],
        statusCode: StatusHttp::HTTP_CREATED
      );
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }

  public function login(LoginRequest $request): JsonResponse
  {
    try {
      $usuario = $this->authService->login($request->validated());
      $token = $this->authService->createToken($usuario);

      return ResponseHttp::statusData(
        msg: 'Inicio de sesión correcto',
        data: [
          'user' => $usuario,
          'token' => $token,
        ]
      );
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }

  public function me(Request $request): JsonResponse
  {
    try {
      $usuario = $request->user();

      if (!$usuario) {
        return ResponseHttp::statusError(
          msg: 'No autenticado',
          statusCode: StatusHttp::HTTP_UNAUTHORIZED
        );
      }

      return ResponseHttp::statusData(
        data: $usuario
      );
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }

  public function logout(Request $request): JsonResponse
  {
    try {
      $usuario = $request->user();

      if (!$usuario) {
        return ResponseHttp::statusError(
          msg: 'No autenticado',
          statusCode: StatusHttp::HTTP_UNAUTHORIZED
        );
      }

      $this->authService->logout($usuario);

      return ResponseHttp::statusOK('Sesión finalizada correctamente');
    } catch (Throwable $e) {
      return ControllerHandler::handler($e);
    }
  }
}
