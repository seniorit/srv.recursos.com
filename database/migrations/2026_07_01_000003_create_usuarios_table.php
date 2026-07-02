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
    Schema::create('usuarios', function (Blueprint $table) {
      $table->uuidCompat('id')->primary();
      $table->uuidCompat('empleado_id');
      $table->string('username', 50)->unique();
      $table->string('nombre', 150);
      $table->string('email', 100)->unique();
      $table->string('password', 255);
      $table->string('rol', 50);
      $table->boolean('activo')->default(true);

      $table->foreign('empleado_id')->references('id')->on('empleados')->nullOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('usuarios');
  }
};
