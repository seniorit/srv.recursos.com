# Diseño de Base de Datos para Sistema de Nómina y Asistencia (WorkforceOS - Venezuela)

Este documento detalla el diseño relacional de la base de datos para la conexión con el backend de Laravel vía API. El diseño es 100% compatible con **PostgreSQL** y **MySQL**, utilizando nomenclatura estándar en inglés en `snake_case` para las tablas y campos corporativos, proporcionando coherencia con los tipos definidos en el frontend.

---

## Índice de Tablas

1. [table: `empresas`](#1-tabla-empresas) — Ficha General Corporativa (Multiempresa)
2. [table: `empleados`](#2-tabla-empleados) — Ficha de Colaboradores (incluye Datos Bancarios, Pago Móvil y Salario)
3. [table: `usuarios`](#3-tabla-usuarios) — Cuentas de Acceso (Gerente / Empleado)
4. [table: `asistencias`](#4-tabla-asistencias) — Registro del Reloj Diario
5. [table: `historicos_nominas`](#5-tabla-historicos_nominas) — Cabecera de Períodos de Nómina Generados
6. [table: `recibos_nominas`](#6-tabla-recibos_nominas) — Detalle de Recibo de Pago Individual por Colaborador

---

## 1. Tabla: `empresas`
Almacena el registro mercantil, fiscal y financiero de las razones sociales habilitadas. Soporta operación multiempresa.

### Campos
| Campo | Tipo de Dato | Restricción | Descripción |
| :--- | :--- | :--- | :--- |
| `id` | BigInteger (Auto-increment) o UUID | Primary Key | Identificador único de la empresa |
| `nombre_comercial` | String (150) | Not Null | Nombre común/comercial (Ej: "Alimentos Caracas, C.A.") |
| `razon_social` | String (255) | Not Null | Denominación legal completa |
| `rif` | String (20) | Not Null, Unique | Registro de Información Fiscal (Ej: "J-12345678-9") |
| `direccion_fiscal` | Text | Not Null | Dirección fiscal completa según registro |
| `telefono` | String (50) | Not Null | Teléfono central / de contacto |
| `correo_contacto` | String (100) | Not Null | Correo para RRHH o general |
| `sitio_web` | String (150) | Nullable | URL o dominio web corporativo (Ej: "www.empresa.com.ve") |
| `representante_legal`| String (150) | Not Null | Nombre completo del Director o Representante |
| `banco_nombre` | String (100) | Nullable | Nombre del banco para egresos de nómina (Ej: "Banco Mercantil") |
| `banco_cuenta` | String (20) | Nullable | Número de cuenta de 20 dígitos en Venezuela |
| `logo_url` | String (255) | Nullable | Ruta del logotipo corporativo |
| `activa` | Boolean | Default: false | Determina si es la empresa por defecto activa actualmente |
| `created_at` | Timestamp | Nullable | Fecha de creación del registro |
| `updated_at` | Timestamp | Nullable | Fecha de actualización del registro |

### Relaciones
- `hasMany(Empleado)`: Una empresa tiene muchos empleados vinculados.
- `hasMany(HistoricoNomina)`: Una empresa tiene muchos períodos de nómina generados.

---

## 2. Tabla: `empleados`
Contiene la ficha laboral de cada colaborador, incluyendo sus datos de contacto, tipo de contrato, información para el cobro por transferencia bancaria o Pago Móvil, y estructura de remuneración.

### Campos
| Campo | Tipo de Dato | Restricción | Descripción |
| :--- | :--- | :--- | :--- |
| `id` | BigInteger (Auto-increment) o UUID | Primary Key | Identificador único físico de la base de datos |
| `codigo_empleado` | String (30) | Not Null, Unique | Código institucional visible (Ej: "WF-1092-VE") |
| `empresa_id` | Foreign Key | Not Null | Relación con la tabla `empresas` |
| `nombre_completo` | String (150) | Not Null | Nombres y apellidos completos |
| `fecha_nacimiento` | Date | Not Null | Fecha de nacimiento |
| `genero` | Enum or String (50) | Not Null | Valores: `'Masculino'`, `'Femenino'`, `'No binario'`, `'Prefiero no decirlo'` |
| `cedula_identidad` | String (20) | Not Null, Unique | Cédula venezolana formatizada (Ej: "V-18456123" o "E-81234567") |
| `rif` | String (20) | Not Null, Unique | Registro de Información Fiscal personal (sufijo numérico incluido) |
| `fecha_inicio` | Date | Not Null | Fecha de ingreso formal a la compañía (Antigüedad LOTTT) |
| `departamento` | Enum or String (100) | Not Null | Valores: `'Recursos Humanos'`, `'Ingeniería'`, `'Ventas y Marketing'`, `'Finanzas'`, `'Operaciones'`, `'Administración'` |
| `cargo` | String (150) | Not Null | Cargo que ocupa |
| `correo_trabajo` | String (100) | Not Null, Unique | Correo corporativo |
| `telefono` | String (50) | Not Null | Teléfono personal |
| `contacto_emergencia`| Text | Not Null | Nombre y teléfono de contacto para emergencias |
| `banco_nombre` | String (100) | Nullable | Nombre de la entidad financiera (Ej: "Banesco") |
| `banco_cuenta` | String (20) | Nullable | Número de cuenta de 20 dígitos en Venezuela |
| `banco_tipo_cuenta` | Enum or String (30) | Nullable | Valores: `'Corriente'`, `'Ahorro'` |
| `pago_movil_banco_codigo` | String (4) | Nullable | Código de compensación BCV de 4 dígitos (Ej: "0134") |
| `pago_movil_cedula` | String (20) | Nullable | Cédula titular del Pago Móvil (Ej: "V-18456123") |
| `pago_movil_telefono` | String (30) | Nullable | Teléfono receptor (Ej: "0412-3456789") |
| `pago_movil_tipo` | Enum or String (20) | Nullable | Valores: `'Personal'`, `'Tercero'` |
| `tipo_contrato` | Enum or String (100) | Not Null | Valores: `'Tiempo Indeterminado'`, `'Tiempo Determinado'`, `'Por Obra'`, `'Freelance'` |
| `tipo_concepto` | Enum or String (100) | Not Null | Base salarial de nómina. Valores: `'Sueldo Base'`, `'Honorarios Profesionales'`, `'Bono Fijo'` |
| `monto_sueldo_usd` | Decimal (12, 2) | Not Null | Salario contractual pactado en USD (referencia de cambio BCV) |
| `frecuencia_pago` | Enum or String (50) | Not Null | Ciclos de cobros. Valores: `'Mensual'`, `'Quincenal'`, `'Semanal'` |
| `foto_perfil_url` | String (255) | Nullable | Ruta URL de la fotografía de perfil |
| `activo` | Boolean | Default: true | Estado del empleado en la compañía |
| `created_at` | Timestamp | Nullable | Fecha de creación del registro |
| `updated_at` | Timestamp | Nullable | Fecha de actualización del registro |

### Relaciones
- `belongsTo(Empresa)`: El empleado pertenece a una única empresa activa.
- `hasOne(Usuario)`: Un empleado puede tener un usuario de sistema asignado.
- `hasMany(Asistencia)`: Un empleado tiene muchos registros diarios de reloj.
- `hasMany(ReciboNomina)`: Un empleado tiene múltiples recibos de nómina emitidos históricamente.

---

## 3. Tabla: `usuarios`
Cuentas de acceso para autenticación en la API. Admite el control tanto para gerentes de personal como para colaboradores individuales.

### Campos
| Campo | Tipo de Dato | Restricción | Descripción |
| :--- | :--- | :--- | :--- |
| `id` | BigInteger (Auto-increment) o UUID | Primary Key | Identificador único |
| `username` | String (50) | Not Null, Unique | Nombre de login (Ej: "admin", "empleado", o código de cédula) |
| `nombre` | String (150) | Not Null | Nombre legible o descriptivo |
| `email` | String (100) | Not Null, Unique | Correo electrónico de acceso |
| `password` | String (255) | Not Null | Hash de seguridad de la contraseña (Bcrypt) |
| `rol` | Enum or String (50) | Not Null | Privilegios. Valores: `'Gerente de RRHH'`, `'Empleado'` |
| `empleado_id` | Foreign Key | Nullable | Relación con `empleados`. Nullable si es administrador puro sin ficha laboral |
| `activo` | Boolean | Default: true | Determina si la cuenta está habilitada |
| `created_at` | Timestamp | Nullable | Fecha de creación de la cuenta |
| `updated_at` | Timestamp | Nullable | Fecha de actualización de la cuenta |

### Relaciones
- `belongsTo(Empleado)`: Enlaza la cuenta con la ficha única de colaborador (habilitando paneles de recibos y asistencia personal).

---

## 4. Tabla: `asistencias`
Almacena las marcas de ingreso y egreso registradas diariamente en los puntos de control del sistema.

### Campos
| Campo | Tipo de Dato | Restricción | Descripción |
| :--- | :--- | :--- | :--- |
| `id` | BigInteger (Auto-increment) o UUID | Primary Key | Identificador único de asistencia |
| `empleado_id` | Foreign Key | Not Null | Relación con la tabla `empleados` |
| `fecha` | Date | Not Null | Fecha del registro formatizada (YYYY-MM-DD) |
| `hora_entrada` | Time | Nullable | Hora de marcación del ingreso (HH:MM:SS) |
| `hora_salida` | Time | Nullable | Hora de marcación del egreso (HH:MM:SS) |
| `estado` | Enum or String (50) | Not Null | Estado de la jornada. Valores: `'Presente'`, `'Tarde'`, `'Ausente'`, `'Permiso/Reposo'` |
| `comentarios` | Text | Nullable | Notas de incidencias (Ej: "Justificación médica de reposo") |
| `created_at` | Timestamp | Nullable | Timestamp de marcas internas |
| `updated_at` | Timestamp | Nullable | Timestamp de marcas internas |

### Relaciones
- `belongsTo(Empleado)`: Relaciona cada marca del reloj con un único empleado.

---

## 5. Tabla: `historicos_nominas`
Cabecera que agrupa y consolida una nómina global calculada y liquidada en un período de tiempo particular.

### Campos
| Campo | Tipo de Dato | Restricción | Descripción |
| :--- | :--- | :--- | :--- |
| `id` | BigInteger (Auto-increment) o UUID | Primary Key | Identificador único de histórica de nómina |
| `empresa_id` | Foreign Key | Not Null | Relación con la tabla `empresas` |
| `mes` | String (7) | Not Null | Mes en formato YYYY-MM (Ej: "2026-06") |
| `periodo` | Enum or String (100) | Not Null | Lapso pagado. Valores: `'Primera Quincena'`, `'Segunda Quincena'`, `'Mensual'`, `'Semana 1'`, etc. |
| `fecha_generacion` | Date | Not Null | Fecha en que el gerente consolidó la liquidación |
| `total_pagado_ves` | Decimal (15, 2) | Not Null | Sumatoria total liquidada en Bolívares (VES) |
| `total_pagado_usd` | Decimal (15, 2) | Not Null | Sumatoria consolidada referencial en dólares (USD) |
| `tasa_cambio_ref` | Decimal (10, 4) | Not Null | Tasa oficial del Banco Central de Venezuela (BCV) aplicada |
| `cantidad_empleados` | Integer | Not Null | Número de colaboradores incluidos en esta corrida de pago |
| `created_at` | Timestamp | Nullable | Auditoría interna del sistema |
| `updated_at` | Timestamp | Nullable | Auditoría interna del sistema |

### Relaciones
- `belongsTo(Empresa)`: Determina bajo qué firma fiscal se emitió la corrida completa.
- `hasMany(ReciboNomina)`: Un histórico de nómina contiene múltiples recibos individuales calculados.

---

## 6. Tabla: `recibos_nominas`
Detalla el cálculo pormenorizado, retenciones de Ley (LOTTT/SSO/FAOV) y bonificaciones de cada empleado durante una corrida de pago.

### Campos
| Campo | Tipo de Dato | Restricción | Descripción |
| :--- | :--- | :--- | :--- |
| `id` | BigInteger (Auto-increment) o UUID | Primary Key | Identificador del recibo individual |
| `historico_nomina_id`| Foreign Key | Not Null | Relación de dependencia con la cabecera `historicos_nominas` |
| `empleado_id` | Foreign Key | Not Null | Relación con la tabla `empleados` |
| `sueldo_base_usd` | Decimal (12, 2) | Not Null | Salario contractual de base en USD de la ficha del empleado |
| `sueldo_base_ves` | Decimal (12, 2) | Not Null | Salario de base convertido al cambio BCV del período |
| `tasa_cambio_ref` | Decimal (10, 4) | Not Null | Tasa de cambio BCV utilizada para los cálculos |
| `bono_alimentacion_ves`| Decimal (12, 2)| Not Null | Monto de Cestaticket de Ley / Bono de Alimentación pagado |
| `deducciones_sso_ves` | Decimal (12, 2) | Not Null | Deducción al Seguro Social Obligatorio (4% legal) |
| `deducciones_faov_ves`| Decimal (12, 2) | Not Null | Deducción al Fondo de Vivienda y Hábitat (FAOV / Banavih 1% legal) |
| `monto_neto_usd` | Decimal (12, 2) | Not Null | Equivalente neto final estimado en USD |
| `monto_neto_ves` | Decimal (12, 2) | Not Null | Monto neto final a transferir/pagar al colaborador en VES |
| `estado_pago` | Enum or String (50) | Not Null | Estatus actual de transferencia. Valores: `'Pendiente'`, `'Procesado'`, `'Fallido'` |
| `fecha_pago` | Date or Timestamp | Nullable | Instante exacto del pago exitoso |
| `metodo_pago` | Enum or String (50) | Not Null | Canal de egreso físico. Valores: `'Pago Móvil'`, `'Transferencia'`, `'Efectivo'` |
| `created_at` | Timestamp | Nullable | Creación del registro temporal |
| `updated_at` | Timestamp | Nullable | Actualización del registro temporal |

### Relaciones
- `belongsTo(HistoricoNomina)`: El recibo individual pertenece a la cabecera de la nómina consolidada de lote.
- `belongsTo(Empleado)`: El recibo se destina a la cuenta del empleado beneficiario.

---

## Directrices de Integración de Datos para Laravel

1. **Aislamiento Multiempresa**: Toda petición que provenga de la App frontend debe incluir cabeceras o filtros orientados a la empresa activa. Las consultas a `empleados`, `historicos_nominas` y `recibos_nominas` deben incorporar el constraint `where('empresa_id', $empresa_Id)`.
2. **Formato Numérico**: Mantener los campos monetarios con precisión `decimal` (por ejemplo, `12, 2` para sueldos e individuales, o `15, 2` para balances de nómina general) para mitigar imprecisiones de redondeo con las tasas de cambio fluctuantes en Venezuela.
3. **Mapeo de Enums**: Los tipos de datos definidos como `Enum` pueden ser almacenados como `VARCHAR` en la base de datos física para mayor flexibilidad frente a incorporaciones laborales futuras, manteniendo la validación de dominios en la capa de Laravel Model / FormRequest.
4. **Campos Bancarios**: Los códigos de banco (`banco_cuenta`) y números de Pago Móvil deben guardarse con su tipo original de cadena (`string`/`varchar`) para conservar los ceros a la izquierda obligatorios en el sistema bancario nacional de Venezuela (Ej: Banco de Venezuela `"0102"`, Provincial `"0108"`, Banesco `"0134"`).
