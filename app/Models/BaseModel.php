<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class BaseModel extends Model
{
  use HasUuids, HasFactory, Notifiable;

  /**
   * Casts base aplicables a todos los modelos.
   * Pueden ser extendidos o anulados por clases hijas.
   */
  protected function baseCasts(): array
  {
    return [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
  }

  /**
   * Devuelve los casts combinando los base + los definidos en el modelo.
   * Los casts del modelo hijo tienen prioridad (sobrescriben los base).
   * 
   * Combina en este orden:
   * 1. Casts base (created_at, updated_at)
   * 2. Método casts() del modelo hijo (si existe)
   */
  public function getCasts(): array
  {
    $casts = $this->baseCasts();

    // Obtiene los casts del método casts() si existe
    // Usamos reflection para detectar si el método existe en la clase concreta
    $reflection = new \ReflectionClass($this);
    if ($reflection->hasMethod('casts')) {
      $castsMethod = $reflection->getMethod('casts');
      $declaringClass = $castsMethod->getDeclaringClass()->getName();
      // Solo si el método está definido en la clase concreta (no en BaseModel ni Model)
      if ($declaringClass !== self::class && $declaringClass !== \Illuminate\Database\Eloquent\Model::class) {
        $modelCasts = $this->casts();
        $casts = array_merge($casts, $modelCasts);
      }
    }

    return $casts;
  }

  /**
   * Convertir cualquier campo fecha al timezone de la app
   * incluso si la DB nos lo entregó en otro.
   */
  protected function asDateTime($value)
  {
    return parent::asDateTime($value)->timezone(config('app.timezone'));
  }
}
