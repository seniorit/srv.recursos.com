<?php

namespace App\Models;

use App\Enums\EstadoAsistencia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends BaseModel
{

  protected $table = 'asistencias';

  protected $fillable = [
    'empleado_id',
    'fecha',
    'hora_entrada',
    'hora_salida',
    'estado',
    'comentarios',
  ];

  protected $casts = [
    'fecha' => 'date',
    'estado' => EstadoAsistencia::class,
  ];

  public function empleado(): BelongsTo
  {
    return $this->belongsTo(Empleado::class, 'empleado_id');
  }
}
