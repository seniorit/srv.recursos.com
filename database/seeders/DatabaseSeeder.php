<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\Usuario;
use App\Models\Empleado;
use App\Models\Asistencia;
use App\Models\ReciboNomina;
use App\Models\HistoricoNomina;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
  use WithoutModelEvents;

  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    Empresa::factory()
      ->count(3)
      ->create()
      ->each(function (Empresa $empresa) {
        $empleados = Empleado::factory()
          ->count(5)
          ->create(['empresa_id' => $empresa->id]);

        $empleados->each(function (Empleado $empleado) {
          Usuario::factory()->create(['empleado_id' => $empleado->id]);
          Asistencia::factory()->count(10)->create(['empleado_id' => $empleado->id]);
        });

        $historicos = HistoricoNomina::factory()
          ->count(2)
          ->create([
            'empresa_id' => $empresa->id,
            'cantidad_empleados' => $empleados->count(),
          ]);

        $historicos->each(function (HistoricoNomina $historico) use ($empleados) {
          $empleados->each(function (Empleado $empleado) use ($historico) {
            ReciboNomina::factory()->create([
              'historico_nomina_id' => $historico->id,
              'empleado_id' => $empleado->id,
              'tasa_cambio_ref' => $historico->tasa_cambio_ref,
            ]);
          });
        });
      });

    Usuario::factory()->create([
      'username' => 'admin',
      'nombre' => 'Administrador',
      'email' => 'admin@example.com',
      'password' => bcrypt('password'),
    ]);
  }
}
