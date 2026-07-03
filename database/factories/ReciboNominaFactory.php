<?php

namespace Database\Factories;

use App\Models\Empleado;
use App\Enums\EstadoPago;
use App\Enums\MetodoPago;
use App\Models\ReciboNomina;
use App\Models\HistoricoNomina;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ReciboNomina>
 */
class ReciboNominaFactory extends Factory
{
  protected $model = ReciboNomina::class;

  public function definition(): array
  {
    $tasa = $this->faker->randomFloat(4, 10, 35);
    $sueldoUsd = $this->faker->randomFloat(2, 400, 3600);
    $sueldoVes = round($sueldoUsd * $tasa, 2);
    $bono = round($this->faker->randomFloat(2, 20, 120), 2);
    $deduccionesSso = round($sueldoVes * 0.04, 2);
    $deduccionesFaov = round($sueldoVes * 0.015, 2);
    $montoNetoVes = round($sueldoVes + $bono - $deduccionesSso - $deduccionesFaov, 2);
    $montoNetoUsd = round($montoNetoVes / $tasa, 2);

    return [
      'historico_nomina_id' => HistoricoNomina::factory(),
      'empleado_id' => Empleado::factory(),
      'sueldo_base_usd' => $sueldoUsd,
      'sueldo_base_ves' => $sueldoVes,
      'tasa_cambio_ref' => $tasa,
      'bono_alimentacion_ves' => $bono,
      'deducciones_sso_ves' => $deduccionesSso,
      'deducciones_faov_ves' => $deduccionesFaov,
      'monto_neto_usd' => $montoNetoUsd,
      'monto_neto_ves' => $montoNetoVes,
      'estado_pago' => $this->faker->randomElement(EstadoPago::cases())->value,
      'fecha_pago' => $this->faker->optional(0.75)->dateTimeBetween('-30 days', 'now'),
      'metodo_pago' => $this->faker->randomElement(MetodoPago::cases())->value,
    ];
  }
}
