<?php

namespace App\Http\Requests\Auth;

use App\Enums\RolUsuario;
use Illuminate\Validation\Rule;
use App\Http\Requests\RequestImplement;

class RegisterRequest extends RequestImplement
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'username' => ['required', 'string', 'min:1', 'max:50', 'unique:usuarios,username'],
      'nombre' => ['required', 'string', 'min:1', 'max:150'],
      'email' => ['required', 'email', 'max:100', 'unique:usuarios,email'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
      'rol' => ['required', 'string', Rule::in(array_map(fn($case) => $case->value, RolUsuario::cases()))],
      'empleado_id' => ['nullable', 'exists:empleados,id'],
      'activo' => ['sometimes', 'boolean'],
    ];
  }
}
