<?php

namespace Database\Factories;

use App\Enums\RolUsuario;
use App\Models\Empleado;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'nombre' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'rol' => $this->faker->randomElement(RolUsuario::cases())->value,
            'empleado_id' => Empleado::factory(),
            'activo' => true,
        ];
    }
}
