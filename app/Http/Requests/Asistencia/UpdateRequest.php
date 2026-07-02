<?php

namespace App\Http\Requests\Asistencia;

use App\Enums\EstadoAsistencia;
use Illuminate\Validation\Rule;
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
      'empleado_id' => ['sometimes', 'string', 'max:50'],
      'fecha' => ['sometimes', 'date'],
      'hora_entrada' => ['sometimes', 'nullable', 'date_format:H:i:s'],
      'hora_salida' => ['sometimes', 'nullable', 'date_format:H:i:s'],
      'estado' => ['required', 'string', Rule::in(array_map(fn($case) => $case->value, EstadoAsistencia::cases()))],
      'comentarios' => ['sometimes', 'nullable', 'string', 'max:1000'],
    ];
  }
}
