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
    Schema::create('empleados', function (Blueprint $table) {
      $table->uuidCompat('id')->primary();
      $table->uuidCompat('empresa_id');
      $table->string('codigo_empleado', 30)->unique();
      $table->string('nombre_completo', 150);
      $table->date('fecha_nacimiento');
      $table->string('genero', 50);
      $table->string('cedula_identidad', 20)->unique();
      $table->string('rif', 20)->unique();
      $table->date('fecha_inicio');
      $table->string('departamento', 100);
      $table->string('cargo', 150);
      $table->string('correo_trabajo', 100)->unique();
      $table->string('telefono', 50);
      $table->text('contacto_emergencia');
      $table->string('banco_nombre', 100)->nullable();
      $table->string('banco_cuenta', 20)->nullable();
      $table->string('banco_tipo_cuenta', 30)->nullable();
      $table->string('pago_movil_banco_codigo', 4)->nullable();
      $table->string('pago_movil_cedula', 20)->nullable();
      $table->string('pago_movil_telefono', 30)->nullable();
      $table->string('pago_movil_tipo', 20)->nullable();
      $table->string('tipo_contrato', 100);
      $table->string('tipo_concepto', 100);
      $table->decimal('monto_sueldo_usd', 12, 2);
      $table->string('frecuencia_pago', 50);
      $table->string('foto_perfil_url', 255)->nullable();
      $table->boolean('activo')->default(true);

      $table->foreign('empresa_id')->references('id')->on('empresas')->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('empleados');
  }
};
