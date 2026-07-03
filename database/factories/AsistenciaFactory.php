<?php

namespace Database\Factories;

use App\Models\Empleado;
use App\Models\Asistencia;
use App\Enums\EstadoAsistencia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Asistencia>
 */
class AsistenciaFactory extends Factory
{
  protected $model = Asistencia::class;

  public function definition(): array
  {
    $estado = $this->faker->randomElement(EstadoAsistencia::cases())->value;

    return [
      'empleado_id' => Empleado::factory(),
      'fecha' => $this->faker->date('Y-m-d', 'now'),
      'hora_entrada' => $estado === EstadoAsistencia::AUSENTE->value ? null : $this->faker->time('H:i:s'),
      'hora_salida' => $estado === EstadoAsistencia::AUSENTE->value ? null : $this->faker->time('H:i:s'),
      'estado' => $estado,
      'comentarios' => $this->faker->optional(0.4)->sentence(),
    ];
  }
}
