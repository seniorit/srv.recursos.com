<?php

namespace App\Http\Requests\Empresa;

use App\Http\Requests\RequestImplement;

class UpdateRequest extends RequestImplement
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
      'id' => ['required', 'string'],
      'nombre_comercial' => ['sometimes', 'string', 'max:255'],
      'razon_social' => ['sometimes', 'string', 'max:255'],
      'rif' => ['sometimes', 'string', 'max:50'],
      'direccion_fiscal' => ['sometimes', 'nullable', 'string', 'max:255'],
      'telefono' => ['sometimes', 'nullable', 'string', 'max:50'],
      'correo_contacto' => ['sometimes', 'nullable', 'email', 'max:255'],
      'sitio_web' => ['sometimes', 'nullable', 'url', 'max:255'],
      'representante_legal' => ['sometimes', 'nullable', 'string', 'max:255'],
      'banco_nombre' => ['sometimes', 'nullable', 'string', 'max:255'],
      'banco_cuenta' => ['sometimes', 'nullable', 'string', 'max:100'],
      'logo_url' => ['sometimes', 'nullable', 'url', 'max:255'],
      'activa' => ['sometimes', 'nullable', 'boolean'],
    ];
  }
}
