<?php

namespace App\Models;

use App\Enums\PeriodoNomina;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricoNomina extends BaseModel
{

  protected $table = 'historicos_nominas';

  protected $fillable = [
    'empresa_id',
    'mes',
    'periodo',
    'fecha_generacion',
    'total_pagado_ves',
    'total_pagado_usd',
    'tasa_cambio_ref',
    'cantidad_empleados',
  ];

  protected $casts = [
    'periodo' => PeriodoNomina::class,
    'fecha_generacion' => 'date',
    'total_pagado_ves' => 'decimal:2',
    'total_pagado_usd' => 'decimal:2',
    'tasa_cambio_ref' => 'decimal:4',
    'cantidad_empleados' => 'integer',
  ];

  public function empresa(): BelongsTo
  {
    return $this->belongsTo(Empresa::class, 'empresa_id');
  }

  public function recibosNominas(): HasMany
  {
    return $this->hasMany(ReciboNomina::class, 'historico_nomina_id');
  }
}
