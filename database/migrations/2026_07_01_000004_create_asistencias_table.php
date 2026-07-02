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
    Schema::create('asistencias', function (Blueprint $table) {
      $table->uuidCompat('id')->primary();
      $table->uuidCompat('empleado_id');
      $table->date('fecha');
      $table->time('hora_entrada')->nullable();
      $table->time('hora_salida')->nullable();
      $table->string('estado', 50);
      $table->text('comentarios')->nullable();

      $table->foreign('empleado_id')->references('id')->on('empleados')->nullOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('asistencias');
  }
};
