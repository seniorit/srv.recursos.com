<?php

namespace App\Http\Services;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Collection;

class EmpresaService
{
  public function getAll(): Collection
  {
    return Empresa::orderBy('nombre_comercial', 'asc')->get();
  }

  public function getById(string $id): Empresa
  {
    return Empresa::findOrFail($id);
  }

  public function create(array $data): Empresa
  {
    return Empresa::create($data);
  }

  public function update(string $id, array $data): Empresa
  {
    $empresa = $this->getById($id);
    $empresa->update($data);

    return $empresa->fresh();
  }

  public function delete(string $id): Empresa
  {
    $empresa = $this->getById($id);
    $empresa->delete();

    return $empresa;
  }
}
