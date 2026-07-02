<?php

namespace App\Http\Requests\Asistencia;

use App\Enums\EstadoAsistencia;
use Illuminate\Validation\Rule;
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
      'empleado_id' => ['required', 'string', 'max:50'],
      'fecha' => ['required', 'date'],
      'hora_entrada' => ['nullable', 'date_format:H:i:s'],
      'hora_salida' => ['nullable', 'date_format:H:i:s'],
      'estado' => ['required', 'string',Rule::in(array_map(fn($case) => $case->value, EstadoAsistencia::cases()))],
      'comentarios' => ['nullable', 'string', 'max:1000'],
    ];
  }
}
