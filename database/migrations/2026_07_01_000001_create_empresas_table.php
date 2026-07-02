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
    Schema::create('empresas', function (Blueprint $table) {
      $table->uuidCompat('id')->primary();
      $table->string('nombre_comercial', 150);
      $table->string('razon_social', 255);
      $table->string('rif', 20)->unique();
      $table->text('direccion_fiscal');
      $table->string('telefono', 50);
      $table->string('correo_contacto', 100);
      $table->string('sitio_web', 150)->nullable();
      $table->string('representante_legal', 150);
      $table->string('banco_nombre', 100)->nullable();
      $table->string('banco_cuenta', 20)->nullable();
      $table->string('logo_url', 255)->nullable();
      $table->boolean('activa')->default(false);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('empresas');
  }
};
