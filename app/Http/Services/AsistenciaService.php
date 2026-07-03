<?php

namespace App\Http\Services;

use App\Models\Asistencia;
use Illuminate\Database\Eloquent\Collection;

class AsistenciaService
{
  public function getAll(): Collection
  {
    return Asistencia::orderBy('fecha', 'desc')->get();
  }

  public function getById(string $id): Asistencia
  {
    return Asistencia::findOrFail($id);
  }

  public function create(array $data): Asistencia
  {
    return Asistencia::create($data);
  }

  public function update(string $id, array $data): Asistencia
  {
    $asistencia = $this->getById($id);
    $asistencia->update($data);

    return $asistencia->fresh();
  }

  public function delete(string $id): Asistencia
  {
    $asistencia = $this->getById($id);
    $asistencia->delete();

    return $asistencia;
  }
}
