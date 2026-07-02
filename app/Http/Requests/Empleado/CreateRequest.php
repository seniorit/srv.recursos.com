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
      'empresa_id' => ['required', 'exists:empresas,id'],
      'codigo_empleado' => ['required', 'string', 'min:1', 'max:30'],
      'nombre_completo' => ['required', 'string', 'min:1', 'max:150'],
      'fecha_nacimiento' => ['required', 'date'],
      'genero' => ['required', 'string', Rule::in(array_map(fn($case) => $case->value, Genero::cases()))],
      'cedula_identidad' => ['required', 'string', 'min:1', 'max:20'],
      'rif' => ['required', 'string', 'min:1', 'max:20'],
      'fecha_inicio' => ['required', 'date'],
      'departamento' => ['required', 'string', Rule::in(array_map(fn($case) => $case->value, Departamento::cases()))],
      'cargo' => ['required', 'string', 'min:1', 'max:150'],
      'correo_trabajo' => ['required', 'string', 'min:1', 'max:100'],
      'telefono' => ['required', 'string', 'min:1', 'max:50'],
      'contacto_emergencia' => ['required', 'string', 'min:1'],
      'banco_nombre' => ['nullable', 'string', 'min:1', 'max:100'],
      'banco_cuenta' => ['nullable', 'string', 'min:1', 'max:20'],
      'banco_tipo_cuenta' => ['nullable', 'string', Rule::in(array_map(fn($case) => $case->value, TipoBancoCuenta::cases()))],
      'pago_movil_banco_codigo' => ['nullable', 'string', 'min:1', 'max:4'],
      'pago_movil_cedula' => ['nullable', 'string', 'min:1', 'max:20'],
      'pago_movil_telefono' => ['nullable', 'string', 'min:1', 'max:30'],
      'pago_movil_tipo' => ['nullable', 'string', Rule::in(array_map(fn($case) => $case->value, PagoMovilTipo::cases()))],
      'tipo_contrato' => ['required', 'string', Rule::in(array_map(fn($case) => $case->value, TipoContrato::cases()))],
      'tipo_concepto' => ['required', 'string', Rule::in(array_map(fn($case) => $case->value, TipoConcepto::cases()))],
      'monto_sueldo_usd' => ['required', 'numeric'],
      'frecuencia_pago' => ['required', 'string', Rule::in(array_map(fn($case) => $case->value, FrecuenciaPago::cases()))],
      'foto_perfil_url' => ['nullable', 'string', 'min:1', 'max:255'],
      'activo' => ['required', 'boolean']
    ];
  }
}

        // 'genero' => Genero::class,
        // 'departamento' => Departamento::class,
        // 'banco_tipo_cuenta' => TipoBancoCuenta::class,
        // 'pago_movil_tipo' => PagoMovilTipo::class,
        // 'tipo_contrato' => TipoContrato::class,
        // 'tipo_concepto' => TipoConcepto::class,
        // 'frecuencia_pago' => FrecuenciaPago::class,
