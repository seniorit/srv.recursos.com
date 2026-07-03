<?php

namespace App\Http\Services;

use App\Models\Empleado;
use App\Models\Asistencia;
use App\Models\ReciboNomina;
use App\Models\HistoricoNomina;

class NominaService
{
  public function historicos()
  {
    return HistoricoNomina::with('empresa')
      ->orderBy('fecha_generacion', 'desc')
      ->get();
  }

  public function recibos()
  {
    return ReciboNomina::with(['empleado', 'historicoNomina'])
      ->orderBy('created_at', 'desc')
      ->get();
  }

  public function dashboardStats(): array
  {
    $totalEmpleadosActivos = Empleado::where('activo', true)->count();
    $asistenciaHoy = Asistencia::whereDate('fecha', now()->toDateString())->count();
    $retardoHoy = Asistencia::whereDate('fecha', now()->toDateString())
      ->where('estado', 'Tarde')
      ->count();
    $ausentesHoy = Asistencia::whereDate('fecha', now()->toDateString())
      ->where('estado', 'Ausente')
      ->count();

    return [
      'nominatotalUsd' => 0,
      'nominatotalVes' => 0,
      'asistenciaHoyPorcentaje' => $totalEmpleadosActivos > 0 ? round(($asistenciaHoy / $totalEmpleadosActivos) * 100, 2) : 0,
      'retardoHoyContador' => $retardoHoy,
      'ausentesHoyContador' => $ausentesHoy,
      'totalEmpleadosActivos' => $totalEmpleadosActivos,
    ];
  }
}
