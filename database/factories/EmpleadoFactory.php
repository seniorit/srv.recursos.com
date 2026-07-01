<?php

namespace Database\Factories;

use App\Enums\Departamento;
use App\Enums\FrecuenciaPago;
use App\Enums\Genero;
use App\Enums\PagoMovilTipo;
use App\Enums\TipoBancoCuenta;
use App\Enums\TipoConcepto;
use App\Enums\TipoContrato;
use App\Models\Empresa;
use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empleado>
 */
class EmpleadoFactory extends Factory
{
    protected $model = Empleado::class;

    public function definition(): array
    {
        return [
            'codigo_empleado' => 'WF-' . $this->faker->unique()->numberBetween(1000, 9999),
            'empresa_id' => Empresa::factory(),
            'nombre_completo' => $this->faker->name(),
            'fecha_nacimiento' => $this->faker->date(),
            'genero' => $this->faker->randomElement(Genero::cases())->value,
            'cedula_identidad' => 'V-' . $this->faker->numerify('########'),
            'rif' => 'V-' . $this->faker->numerify('########'),
            'fecha_inicio' => $this->faker->date(),
            'departamento' => $this->faker->randomElement(Departamento::cases())->value,
            'cargo' => $this->faker->jobTitle(),
            'correo_trabajo' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'contacto_emergencia' => $this->faker->name() . ' - ' . $this->faker->phoneNumber(),
            'banco_nombre' => $this->faker->randomElement(['Banesco', 'Mercantil', 'Venezolano de Crédito']),
            'banco_cuenta' => $this->faker->numerify('##########'),
            'banco_tipo_cuenta' => $this->faker->randomElement(TipoBancoCuenta::cases())->value,
            'pago_movil_banco_codigo' => $this->faker->numerify('####'),
            'pago_movil_cedula' => 'V-' . $this->faker->numerify('########'),
            'pago_movil_telefono' => $this->faker->phoneNumber(),
            'pago_movil_tipo' => $this->faker->randomElement(PagoMovilTipo::cases())->value,
            'tipo_contrato' => $this->faker->randomElement(TipoContrato::cases())->value,
            'tipo_concepto' => $this->faker->randomElement(TipoConcepto::cases())->value,
            'monto_sueldo_usd' => $this->faker->randomFloat(2, 500, 5000),
            'frecuencia_pago' => $this->faker->randomElement(FrecuenciaPago::cases())->value,
            'foto_perfil_url' => $this->faker->imageUrl(200, 200),
            'activo' => true,
        ];
    }
}
