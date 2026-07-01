<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historicos_nominas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->string('mes', 7);
            $table->string('periodo', 100);
            $table->date('fecha_generacion');
            $table->decimal('total_pagado_ves', 15, 2);
            $table->decimal('total_pagado_usd', 15, 2);
            $table->decimal('tasa_cambio_ref', 10, 4);
            $table->integer('cantidad_empleados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historicos_nominas');
    }
};
