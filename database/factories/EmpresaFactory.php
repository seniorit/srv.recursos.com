<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empresa>
 */
class EmpresaFactory extends Factory
{
    protected $model = Empresa::class;

    public function definition(): array
    {
        return [
            'nombre_comercial' => $this->faker->company(),
            'razon_social' => $this->faker->company() . ' C.A.',
            'rif' => 'J-' . $this->faker->numerify('########') . '-' . $this->faker->randomDigit(),
            'direccion_fiscal' => $this->faker->address(),
            'telefono' => $this->faker->phoneNumber(),
            'correo_contacto' => $this->faker->safeEmail(),
            'sitio_web' => $this->faker->domainName(),
            'representante_legal' => $this->faker->name(),
            'banco_nombre' => $this->faker->randomElement(['Banesco', 'Mercantil', 'Venezolano de Crédito']),
            'banco_cuenta' => $this->faker->numerify('##########'),
            'logo_url' => $this->faker->imageUrl(200, 200),
            'activa' => true,
        ];
    }
}
