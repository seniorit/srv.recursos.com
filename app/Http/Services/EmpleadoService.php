<?php

namespace App\Http\Services;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Collection;

class EmpleadoService
{
  public function getAll(): Collection
  {
    return Empleado::orderBy('codigo_empleado', 'asc')->get();
  }

  public function getById(string $id): Empleado
  {
    return Empleado::findOrFail($id);
  }

  public function create(array $data): Empleado
  {
    return Empleado::create($data);
  }

  public function update(string $id, array $data): Empleado
  {
    $empleado = $this->getById($id);
    $empleado->update($data);

    return $empleado->fresh();
  }

  public function delete(string $id): Empleado
  {
    $empleado = $this->getById($id);
    $empleado->delete();

    return $empleado;
  }
}
