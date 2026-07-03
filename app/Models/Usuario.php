<?php

namespace App\Models;

use App\Enums\RolUsuario;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
  use HasApiTokens, HasFactory, HasUuids, Notifiable;

  protected $table = 'usuarios';

  protected $fillable = [
    'username',
    'nombre',
    'email',
    'password',
    'rol',
    'empleado_id',
    'activo',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'rol' => RolUsuario::class,
    'activo' => 'boolean',
    'password' => 'hashed',
  ];

  public function empleado(): BelongsTo
  {
    return $this->belongsTo(Empleado::class, 'empleado_id');
  }
}
