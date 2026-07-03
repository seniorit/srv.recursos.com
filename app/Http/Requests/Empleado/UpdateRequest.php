<?php

namespace App\Http\Requests\Empleado;

use App\Enums\Genero;
use App\Enums\Departamento;
use App\Enums\TipoConcepto;
use App\Enums\TipoContrato;
use App\Enums\PagoMovilTipo;
use App\Enums\FrecuenciaPago;
use App\Enums\TipoBancoCuenta;
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
      'empresa_id' => ['sometimes', 'exists:empresas,id'],
      'codigo_empleado' => ['sometimes', 'string', 'min:1', 'max:30'],
      'nombre_completo' => ['sometimes', 'string', 'min:1', 'max:150'],
      'fecha_nacimiento' => ['sometimes', 'date'],
      'genero' => ['sometimes', 'string', Rule::in(array_map(fn($case) => $case->value, Genero::cases()))],
      'cedula_identidad' => ['sometimes', 'string', 'min:1', 'max:20'],
      'rif' => ['sometimes', 'string', 'min:1', 'max:20'],
      'fecha_inicio' => ['sometimes', 'date'],
      'departamento' => ['sometimes', 'string', Rule::in(array_map(fn($case) => $case->value, Departamento::cases()))],
      'cargo' => ['sometimes', 'string', 'min:1', 'max:150'],
      'correo_trabajo' => ['sometimes', 'string', 'min:1', 'max:100'],
      'telefono' => ['sometimes', 'string', 'min:1', 'max:50'],
      'contacto_emergencia' => ['sometimes', 'string', 'min:1'],
      'banco_nombre' => ['nullable', 'string', 'min:1', 'max:100'],
      'banco_cuenta' => ['nullable', 'string', 'min:1', 'max:20'],
      'banco_tipo_cuenta' => ['nullable', 'string', Rule::in(array_map(fn($case) => $case->value, TipoBancoCuenta::cases()))],
      'pago_movil_banco_codigo' => ['nullable', 'string', 'min:1', 'max:4'],
      'pago_movil_cedula' => ['nullable', 'string', 'min:1', 'max:20'],
      'pago_movil_telefono' => ['nullable', 'string', 'min:1', 'max:30'],
      'pago_movil_tipo' => ['nullable', 'string', Rule::in(array_map(fn($case) => $case->value, PagoMovilTipo::cases()))],
      'tipo_contrato' => ['sometimes', 'string', Rule::in(array_map(fn($case) => $case->value, TipoContrato::cases()))],
      'tipo_concepto' => ['sometimes', 'string', Rule::in(array_map(fn($case) => $case->value, TipoConcepto::cases()))],
      'monto_sueldo_usd' => ['sometimes', 'numeric'],
      'frecuencia_pago' => ['sometimes', 'string', Rule::in(array_map(fn($case) => $case->value, FrecuenciaPago::cases()))],
      'foto_perfil_url' => ['nullable', 'string', 'min:1', 'max:255'],
      'activo' => ['sometimes', 'boolean']
    ];
  }
}
