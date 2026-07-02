<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('recibos_nominas', function (Blueprint $table) {
      $table->uuidCompat('id')->primary();
      $table->uuidCompat('historico_nomina_id');
      $table->uuidCompat('empleado_id');

      $table->decimal('sueldo_base_usd', 12, 2);
      $table->decimal('sueldo_base_ves', 12, 2);
      $table->decimal('tasa_cambio_ref', 10, 4);
      $table->decimal('bono_alimentacion_ves', 12, 2);
      $table->decimal('deducciones_sso_ves', 12, 2);
      $table->decimal('deducciones_faov_ves', 12, 2);
      $table->decimal('monto_neto_usd', 12, 2);
      $table->decimal('monto_neto_ves', 12, 2);
      $table->string('estado_pago', 50);
      $table->dateTime('fecha_pago')->nullable();
      $table->string('metodo_pago', 50);

      $table->foreign('historico_nomina_id')->references('id')->on('historicos_nominas')->cascadeOnDelete();
      $table->foreign('empleado_id')->references('id')->on('empleados')->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('recibos_nominas');
  }
};
