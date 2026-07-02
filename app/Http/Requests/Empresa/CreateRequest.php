<?php

namespace App\Http\Requests\Empresa;

use App\Http\Requests\RequestImplement;

class CreateRequest extends RequestImplement
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'nombre_comercial' => ['required', 'string', 'max:255'],
      'razon_social' => ['required', 'string', 'max:255'],
      'rif' => ['required', 'string', 'max:50'],
      'direccion_fiscal' => ['nullable', 'string', 'max:255'],
      'telefono' => ['nullable', 'string', 'max:50'],
      'correo_contacto' => ['nullable', 'email', 'max:255'],
      'sitio_web' => ['nullable', 'url', 'max:255'],
      'representante_legal' => ['nullable', 'string', 'max:255'],
      'banco_nombre' => ['nullable', 'string', 'max:255'],
      'banco_cuenta' => ['nullable', 'string', 'max:100'],
      'logo_url' => ['nullable', 'url', 'max:255'],
      'activa' => ['nullable', 'boolean'],
    ];
  }
}
