<?php

namespace App\Models;

use App\Enums\EstadoPago;
use App\Enums\MetodoPago;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReciboNomina extends BaseModel
{

  protected $table = 'recibos_nominas';

  protected $fillable = [
    'historico_nomina_id',
    'empleado_id',
    'sueldo_base_usd',
    'sueldo_base_ves',
    'tasa_cambio_ref',
    'bono_alimentacion_ves',
    'deducciones_sso_ves',
    'deducciones_faov_ves',
    'monto_neto_usd',
    'monto_neto_ves',
    'estado_pago',
    'fecha_pago',
    'metodo_pago',
  ];

  protected $casts = [
    'sueldo_base_usd' => 'decimal:2',
    'sueldo_base_ves' => 'decimal:2',
    'tasa_cambio_ref' => 'decimal:4',
    'bono_alimentacion_ves' => 'decimal:2',
    'deducciones_sso_ves' => 'decimal:2',
    'deducciones_faov_ves' => 'decimal:2',
    'monto_neto_usd' => 'decimal:2',
    'monto_neto_ves' => 'decimal:2',
    'estado_pago' => EstadoPago::class,
    'fecha_pago' => 'datetime',
    'metodo_pago' => MetodoPago::class,
  ];

  public function historicoNomina(): BelongsTo
  {
    return $this->belongsTo(HistoricoNomina::class, 'historico_nomina_id');
  }

  public function empleado(): BelongsTo
  {
    return $this->belongsTo(Empleado::class, 'empleado_id');
  }
}
