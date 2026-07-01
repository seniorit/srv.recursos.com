# Modelos de Eloquent y Enums para Laravel (WorkforceOS - Venezuela)

Este documento contiene la implementación lista para usar de los **Modelos de Eloquent** y los **Enums de PHP (PHP 8.1+)** correspondientes al esquema relacional de base de datos diseñado para el sistema de nómina y asistencia.

---

## Índice de Contenidos
1. [Enums de PHP](#1-enums-de-php-81) — Clases Enums nativas para validaciones y tipado
2. [Modelos de Eloquent](#2-modelos-de-eloquent)
   - [Empresa.php](#empresa)
   - [Empleado.php](#empleado)
   - [Usuario.php (Auth)](#usuario)
   - [Asistencia.php](#asistencia)
   - [HistoricoNomina.php](#historiconomina)
   - [ReciboNomina.php](#recibonomina)
3. [Directrices y Recomendaciones de Uso](#3-directrices-y-recomendaciones-de-uso)

---

## 1. Enums de PHP (PHP 8.1+)

Definir Enums respaldados (*Backed Enums*) en PHP permite realizar un mapeo directo y seguro de los valores del frontend a la base de datos y a las reglas de validación en los FormRequests de Laravel.

### `App\Enums\Genero.php`
```php
<?php

namespace App\Enums;

enum Genero: string
{
    case MASCULINO = 'Masculino';
    case FEMENINO = 'Femenino';
    case NO_BINARIO = 'No binario';
    case NO_DECIRLO = 'Prefiero no decirlo';
}
```

### `App\Enums\Departamento.php`
```php
<?php

namespace App\Enums;

enum Departamento: string
{
    case RECURSOS_HUMANOS = 'Recursos Humanos';
    case INGENIERIA = 'Ingeniería';
    case VENTAS_MARKETING = 'Ventas y Marketing';
    case FINANZAS = 'Finanzas';
    case OPERACIONES = 'Operaciones';
    case ADMINISTRACION = 'Administración';
}
```

### `App\Enums\TipoBancoCuenta.php`
```php
<?php

namespace App\Enums;

enum TipoBancoCuenta: string
{
    case CORRIENTE = 'Corriente';
    case AHORRO = 'Ahorro';
}
```

### `App\Enums\PagoMovilTipo.php`
```php
<?php

namespace App\Enums;

enum PagoMovilTipo: string
{
    case PERSONAL = 'Personal';
    case TERCERO = 'Tercero';
}
```

### `App\Enums\TipoContrato.php`
```php
<?php

namespace App\Enums;

enum TipoContrato: string
{
    case TIEMPO_INDETERMINADO = 'Tiempo Indeterminado';
    case TIEMPO_DETERMINADO = 'Tiempo Determinado';
    case POR_OBRA = 'Por Obra';
    case FREELANCE = 'Freelance';
}
```

### `App\Enums\TipoConcepto.php`
```php
<?php

namespace App\Enums;

enum TipoConcepto: string
{
    case SUELDO_BASE = 'Sueldo Base';
    case HONORARIOS_PROFESIONALES = 'Honorarios Profesionales';
    case BONO_FIJO = 'Bono Fijo';
}
```

### `App\Enums\FrecuenciaPago.php`
```php
<?php

namespace App\Enums;

enum FrecuenciaPago: string
{
    case MENSUAL = 'Mensual';
    case QUINCENAL = 'Quincenal';
    case SEMANAL = 'Semanal';
}
```

### `App\Enums\RolUsuario.php`
```php
<?php

namespace App\Enums;

enum RolUsuario: string
{
    case GERENTE_RRHH = 'Gerente de RRHH';
    case EMPLEADO = 'Empleado';
}
```

### `App\Enums\EstadoAsistencia.php`
```php
<?php

namespace App\Enums;

enum EstadoAsistencia: string
{
    case PRESENTE = 'Presente';
    case TARDE = 'Tarde';
    case AUSENTE = 'Ausente';
    case PERMISO_REPOSO = 'Permiso/Reposo';
}
```

### `App\Enums\PeriodoNomina.php`
```php
<?php

namespace App\Enums;

enum PeriodoNomina: string
{
    case PRIMERA_QUINCENA = 'Primera Quincena';
    case SEGUNDA_QUINCENA = 'Segunda Quincena';
    case MENSUAL = 'Mensual';
    case SEMANA_1 = 'Semana 1';
    case SEMANA_2 = 'Semana 2';
    case SEMANA_3 = 'Semana 3';
    case SEMANA_4 = 'Semana 4';
}
```

### `App\Enums\EstadoPago.php`
```php
<?php

namespace App\Enums;

enum EstadoPago: string
{
    case PENDIENTE = 'Pendiente';
    case PROCESADO = 'Procesado';
    case FALLIDO = 'Fallido';
}
```

### `App\Enums\MetodoPago.php`
```php
<?php

namespace App\Enums;

enum MetodoPago: string
{
    case PAGO_MOVIL = 'Pago Móvil';
    case TRANSFERENCIA = 'Transferencia';
    case EFECTIVO = 'Efectivo';
}
```

---

## 2. Modelos de Eloquent

### Empresa
`App\Models\Empresa.php`
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    /**
     * Obtiene los empleados de la empresa.
     */
    public function empleados(): HasMany
    {
        return $this->hasMany(Empleado::class, 'empresa_id');
    }

    /**
     * Obtiene los registros históricos de nóminas del lote de la empresa.
     */
    public function historicosNominas(): HasMany
    {
        return $this->hasMany(HistoricoNomina::class, 'empresa_id');
    }
}
```

---

### Empleado
`App\Models\Empleado.php`
```php
<?php

namespace App\Models;

use App\Enums\Genero;
use App\Enums\Departamento;
use App\Enums\TipoBancoCuenta;
use App\Enums\PagoMovilTipo;
use App\Enums\TipoContrato;
use App\Enums\TipoConcepto;
use App\Enums\FrecuenciaPago;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';

    protected $fillable = [
        'codigo_empleado',
        'empresa_id',
        'nombre_completo',
        'fecha_nacimiento',
        'genero',
        'cedula_identidad',
        'rif',
        'fecha_inicio',
        'departamento',
        'cargo',
        'correo_trabajo',
        'telefono',
        'contacto_emergencia',
        'banco_nombre',
        'banco_cuenta',
        'banco_tipo_cuenta',
        'pago_movil_banco_codigo',
        'pago_movil_cedula',
        'pago_movil_telefono',
        'pago_movil_tipo',
        'tipo_contrato',
        'tipo_concepto',
        'monto_sueldo_usd',
        'frecuencia_pago',
        'foto_perfil_url',
        'activo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_inicio' => 'date',
        'genero' => Genero::class,
        'departamento' => Departamento::class,
        'banco_tipo_cuenta' => TipoBancoCuenta::class,
        'pago_movil_tipo' => PagoMovilTipo::class,
        'tipo_contrato' => TipoContrato::class,
        'tipo_concepto' => TipoConcepto::class,
        'frecuencia_pago' => FrecuenciaPago::class,
        'monto_sueldo_usd' => 'decimal:2',
        'activo' => 'boolean',
    ];

    /**
     * Obtiene la empresa a la que pertenece el empleado.
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    /**
     * Obtiene la cuenta de usuario vinculada al empleado.
     */
    public function usuario(): HasOne
    {
        return $this->hasOne(Usuario::class, 'empleado_id');
    }

    /**
     * Obtiene las asistencias marcadas por el empleado.
     */
    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class, 'empleado_id');
    }

    /**
     * Obtiene los recibos de nómina del empleado.
     */
    public function recibosNominas(): HasMany
    {
        return $this->hasMany(ReciboNomina::class, 'empleado_id');
    }
}
```

---

### Usuario
`App\Models\Usuario.php`
```php
<?php

namespace App\Models;

use App\Enums\RolUsuario;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Recomiendo usar Sanctum para APIs seguras

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;

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
        'password' => 'hashed', // Laravel 10+ encriptación automática
    ];

    /**
     * Obtiene la ficha laboral (empleado) asociada al usuario.
     */
    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
```

---

### Asistencia
`App\Models\Asistencia.php`
```php
<?php

namespace App\Models;

use App\Enums\EstadoAsistencia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencias';

    protected $fillable = [
        'empleado_id',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'estado',
        'comentarios',
    ];

    protected $casts = [
        'fecha' => 'date',
        'estado' => EstadoAsistencia::class,
    ];

    /**
     * Obtiene el empleado asociado al registro de asistencia.
     */
    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
```

---

### HistoricoNomina
`App\Models\HistoricoNomina.php`
```php
<?php

namespace App\Models;

use App\Enums\PeriodoNomina;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoricoNomina extends Model
{
    use HasFactory;

    protected $table = 'historicos_nominas';

    protected $fillable = [
        'empresa_id',
        'mes',
        'periodo',
        'fecha_generacion',
        'total_pagado_ves',
        'total_pagado_usd',
        'tasa_cambio_ref',
        'cantidad_empleados',
    ];

    protected $casts = [
        'periodo' => PeriodoNomina::class,
        'fecha_generacion' => 'date',
        'total_pagado_ves' => 'decimal:2',
        'total_pagado_usd' => 'decimal:2',
        'tasa_cambio_ref' => 'decimal:4',
        'cantidad_empleados' => 'integer',
    ];

    /**
     * Obtiene la empresa que generó esta nómina.
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    /**
     * Obtiene los recibos de nómina contenidos en este histórico general.
     */
    public function recibosNominas(): HasMany
    {
        return $this->hasMany(ReciboNomina::class, 'historico_nomina_id');
    }
}
```

---

### ReciboNomina
`App\Models\ReciboNomina.php`
```php
<?php

namespace App\Models;

use App\Enums\EstadoPago;
use App\Enums\MetodoPago;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReciboNomina extends Model
{
    use HasFactory;

    protected $table = 'recibos_nominas';

    protected $fillable = [
        'historico_nomina_id',
        'empleado_id',
        'sueldo_base_usd',
        'sueldo_base_ves',
        'tasa_cambio_ref',
        'bono_alimentacion_ves',
        'deducciones_sso_ves',
        'deducciones_faov_ves',
        'monto_neto_usd',
        'monto_neto_ves',
        'estado_pago',
        'fecha_pago',
        'metodo_pago',
    ];

    protected $casts = [
        'sueldo_base_usd' => 'decimal:2',
        'sueldo_base_ves' => 'decimal:2',
        'tasa_cambio_ref' => 'decimal:4',
        'bono_alimentacion_ves' => 'decimal:2',
        'deducciones_sso_ves' => 'decimal:2',
        'deducciones_faov_ves' => 'decimal:2',
        'monto_neto_usd' => 'decimal:2',
        'monto_neto_ves' => 'decimal:2',
        'estado_pago' => EstadoPago::class,
        'fecha_pago' => 'datetime',
        'metodo_pago' => MetodoPago::class,
    ];

    /**
     * Obtiene el lote o histórico de nómina consolidado al que pertenece este recibo.
     */
    public function historicoNomina(): BelongsTo
    {
        return $this->belongsTo(HistoricoNomina::class, 'historico_nomina_id');
    }

    /**
     * Obtiene el empleado titular del recibo.
     */
    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }
}
```

---

## 3. Directrices y Recomendaciones de Uso

1. **Casting de Enums Nativos (PHP 8.1+)**:
   En Laravel 9 y 10, puedes castear atributos de modelos directamente a objetos `Enum` declarando el nombre de la clase del Enum en el array `$casts` (como se ha hecho en todos los modelos provistos). Al hacer esto, Laravel serializa y deserializa de manera transparente los valores al interactuar con la base de datos.
   
2. **Validación en Controladores / FormRequests**:
   A la hora de validar entradas HTTP en tus controladores, puedes validar fácilmente que un campo coincida con los Enums utilizando la regla de validación de Laravel:
   ```php
   use App\Enums\Departamento;
   use Illuminate\Validation\Rules\Enum;

   $request->validate([
       'departamento' => ['required', new Enum(Departamento::class)],
   ]);
   ```

3. **Cadenas de Cuenta Bancaria y Pago Móvil**:
   Para los campos como `banco_cuenta`, `pago_movil_banco_codigo` y `pago_movil_telefono`, se ha configurado la persistencia como `string` sin casts numéricos adicionales. Esto garantiza la integridad de los ceros a la izquierda obligatorios en los códigos de banco venezolanos de 4 dígitos (ej: Banesco es `'0134'`) y de los números de cuenta corrientes/ahorros de 20 dígitos.
