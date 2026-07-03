<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Enums\PeriodoNomina;
use App\Models\HistoricoNomina;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\HistoricoNomina>
 */
class HistoricoNominaFactory extends Factory
{
  protected $model = HistoricoNomina::class;

  public function definition(): array
  {
    $fecha = $this->faker->dateTimeBetween('-3 months', 'now');
    $tasa = $this->faker->randomFloat(4, 10, 35);
    $cantidad = $this->faker->numberBetween(3, 10);
    $totalUsd = $this->faker->randomFloat(2, 18000, 52000);
    $totalVes = round($totalUsd * $tasa, 2);

    return [
      'empresa_id' => Empresa::factory(),
      'mes' => $fecha->format('Y-m'),
      'periodo' => $this->faker->randomElement(PeriodoNomina::cases())->value,
      'fecha_generacion' => $fecha->format('Y-m-d'),
      'total_pagado_ves' => $totalVes,
      'total_pagado_usd' => $totalUsd,
      'tasa_cambio_ref' => $tasa,
      'cantidad_empleados' => $cantidad,
    ];
  }
}
