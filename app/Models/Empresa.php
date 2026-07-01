<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'nombre_comercial',
        'razon_social',
        'rif',
        'direccion_fiscal',
        'telefono',
        'correo_contacto',
        'sitio_web',
        'representante_legal',
        'banco_nombre',
        'banco_cuenta',
        'logo_url',
        'activa',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];

    public function empleados(): HasMany
    {
        return $this->hasMany(Empleado::class, 'empresa_id');
    }

    public function historicosNominas(): HasMany
    {
        return $this->hasMany(HistoricoNomina::class, 'empresa_id');
    }
}
