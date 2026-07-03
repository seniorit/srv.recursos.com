<?php

namespace App\Http\Services;

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
  public function register(array $data): Usuario
  {
    return Usuario::create($data);
  }

  public function login(array $data): Usuario
  {
    $query = Usuario::query();

    if (!empty($data['username']) && !empty($data['email'])) {
      $query->where(
        fn($query) => $query
          ->where('username', $data['username'])
          ->orWhere('email', $data['email'])
      );
    } elseif (!empty($data['username'])) {
      $query->where('username', $data['username']);
    } else {
      $query->where('email', $data['email']);
    }

    $usuario = $query->first();

    if (! $usuario || ! Hash::check($data['password'], $usuario->password)) {
      throw ValidationException::withMessages([
        'credentials' => 'Credenciales inválidas.',
      ]);
    }

    return $usuario;
  }

  public function createToken(Usuario $usuario, string $name = 'api-token'): string
  {
    return $usuario->createToken($name)->plainTextToken;
  }

  public function logout(Usuario $usuario): bool
  {
    return (bool) $usuario->currentAccessToken()?->delete();
  }
}
