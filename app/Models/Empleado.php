<?php

namespace App\Models;

use App\Enums\Genero;
use App\Enums\Departamento;
use App\Enums\TipoConcepto;
use App\Enums\TipoContrato;
use App\Enums\PagoMovilTipo;
use App\Enums\FrecuenciaPago;
use App\Enums\TipoBancoCuenta;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Empleado extends BaseModel
{

  protected $table = 'empleados';

  protected $fillable = [
    'codigo_empleado',
    'empresa_id',
    'nombre_completo',
    'fecha_nacimiento',
    'genero',
    'cedula_identidad',
    'rif',
    'fecha_inicio',
    'departamento',
    'cargo',
    'correo_trabajo',
    'telefono',
    'contacto_emergencia',
    'banco_nombre',
    'banco_cuenta',
    'banco_tipo_cuenta',
    'pago_movil_banco_codigo',
    'pago_movil_cedula',
    'pago_movil_telefono',
    'pago_movil_tipo',
    'tipo_contrato',
    'tipo_concepto',
    'monto_sueldo_usd',
    'frecuencia_pago',
    'foto_perfil_url',
    'activo',
  ];

  protected $casts = [
    'fecha_nacimiento' => 'date',
    'fecha_inicio' => 'date',
    'genero' => Genero::class,
    'departamento' => Departamento::class,
    'banco_tipo_cuenta' => TipoBancoCuenta::class,
    'pago_movil_tipo' => PagoMovilTipo::class,
    'tipo_contrato' => TipoContrato::class,
    'tipo_concepto' => TipoConcepto::class,
    'frecuencia_pago' => FrecuenciaPago::class,
    'monto_sueldo_usd' => 'decimal:2',
    'activo' => 'boolean',
  ];

  public function empresa(): BelongsTo
  {
    return $this->belongsTo(Empresa::class, 'empresa_id');
  }

  public function usuario(): HasOne
  {
    return $this->hasOne(Usuario::class, 'empleado_id');
  }

  public function asistencias(): HasMany
  {
    return $this->hasMany(Asistencia::class, 'empleado_id');
  }

  public function recibosNominas(): HasMany
  {
    return $this->hasMany(ReciboNomina::class, 'empleado_id');
  }
}
