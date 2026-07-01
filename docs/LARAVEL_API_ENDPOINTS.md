# Listado de Endpoints para la API en Laravel (api.php)

Este documento define la estructura de rutas, métodos, parámetros esperados y formato de respuestas JSON para la API de **WorkforceOS**. Es un diseño 100% puro para `routes/api.php` de Laravel que se conecta directamente con el frontend.

---

## Estructura de Rutas de la API (`routes/api.php`)

Todas las rutas están agrupadas bajo el prefijo predeterminado `/api` de Laravel y devuelven respuestas de tipo `application/json`. Se sugiere estructurar el archivo de rutas utilizando controladores para cada recurso.

---

## 1. Autenticación (`/api/auth`)

| Método | Endpoint | Descripción | Body (JSON / FormData) / Query Params |
| :--- | :--- | :--- | :--- |
| **POST** | `/auth/login` | Autentica a un usuario (Gerente o Empleado) | `{ "username": "admin", "password": "..." }` |
| **POST** | `/auth/logout` | Revoca el token actual (requiere autenticación) | *Ninguno (Cabecera Authorization)* |
| **GET** | `/auth/me` | Retorna los detalles del usuario autenticado | *Ninguno (Cabecera Authorization)* |

### Respuesta JSON Exitosa Sugerida (`/auth/login`)
```json
{
  "token": "1|LaravelSanctumToken...",
  "usuario": {
    "id": "USR-0001",
    "username": "alejandro.gomez",
    "nombre": "Alejandro Rafael Gómez Rondón",
    "email": "alejandro.gomez@empresa.com.ve",
    "rol": "Empleado",
    "empleado_id": "WF-1092-VE",
    "activo": true
  }
}
```

---

## 2. Gestión de Usuarios (`/api/usuarios`)

| Método | Endpoint | Descripción | Parámetros / Body Esperado |
| :--- | :--- | :--- | :--- |
| **GET** | `/usuarios` | Lista todos los usuarios registrados | *Ninguno* |
| **POST** | `/usuarios` | Registra una nueva cuenta de usuario | `{ "username", "nombre", "email", "password", "rol", "empleado_id"? }` |
| **PUT** | `/usuarios/{id}` | Actualiza información de un usuario específico | `{ "nombre"?, "email"?, "rol"?, "activo"? }` |
| **DELETE** | `/usuarios/{id}` | Desactiva (o elimina lógicamente) a un usuario | *Ninguno* |

---

## 3. Configuración y Tasa de Cambio BCV (`/api/exchange-rate`)

| Método | Endpoint | Descripción | Parámetros / Body Esperado |
| :--- | :--- | :--- | :--- |
| **GET** | `/exchange-rate` | Obtiene el valor actual de la tasa BCV | *Ninguno* |
| **POST** | `/exchange-rate` | Actualiza la tasa referencial VES/USD | `{ "rate": 45.50 }` |

### Respuesta JSON Exitosa Sugerida (`GET /exchange-rate`)
```json
{
  "rate": 45.50
}
```

---

## 4. Gestión Multiempresa (`/api/empresas`)

| Método | Endpoint | Descripción | Parámetros / Body Esperado |
| :--- | :--- | :--- | :--- |
| **GET** | `/empresas` | Obtiene el listado de empresas configuradas | *Ninguno* |
| **POST** | `/empresas` | Crea una nueva ficha corporativa | `{ "nombre_comercial", "razon_social", "rif", "direccion_fiscal", "telefono", "correo_contacto", "sitio_web"?, "representante_legal", "banco_nombre"?, "banco_cuenta"? }` |
| **PUT** | `/empresas/{id}` | Actualiza datos de la empresa | `{ "nombre_comercial"?, "razon_social"?, "rif"?, ..., "activa"? }` |
| **DELETE** | `/empresas/{id}` | Desactiva a la empresa de los registros activos | *Ninguno* |

---

## 5. Gestión de Empleados (`/api/empleados`)

| Método | Endpoint | Descripción | Parámetros / Body Esperado |
| :--- | :--- | :--- | :--- |
| **GET** | `/empleados` | Lista todos los empleados | *Ninguno* |
| **GET** | `/empleados/{id}` | Obtiene la ficha de un empleado en particular | *Ruta `id` (Ej: WF-1092-VE)* |
| **POST** | `/empleados` | Registra un nuevo empleado (Ficha Técnica LOTTT) | `{ "nombre_completo", "fecha_nacimiento", "genero", "cedula_identidad", "rif", "fecha_inicio", "departamento", "cargo", "correo_trabajo", "telefono", "contacto_emergencia", "banco_nombre"?, "banco_cuenta"?, "banco_tipo_cuenta"?, "pago_movil_banco_codigo"?, "pago_movil_cedula"?, "pago_movil_telefono"?, "pago_movil_tipo"?, "tipo_contrato", "tipo_concepto", "monto_sueldo_usd", "frecuencia_pago", "foto_perfil_url"? }` |
| **PUT** | `/empleados/{id}` | Modifica los datos del expediente laboral | `{ "cargo"?, "departamento"?, "monto_sueldo_usd"?, ..., "activo"? }` |
| **DELETE** | `/empleados/{id}` | Da de baja a un empleado (Inactivo) | *Ninguno* |

---

## 6. Control de Asistencia (`/api/asistencias`)

| Método | Endpoint | Descripción | Parámetros / Body Esperado |
| :--- | :--- | :--- | :--- |
| **GET** | `/asistencias` | Obtiene el registro diario general de asistencia | Query param opcional: `?fecha=YYYY-MM-DD` |
| **POST** | `/asistencias/marcar` | Registra marca de entrada o salida (Reloj biométrico/web) | `{ "empleado_id": "WF-1092-VE", "tipo": "entrada" o "salida", "comentarios"? }` |
| **POST** | `/asistencias/manual` | Permite al administrador cargar una asistencia manual | `{ "empleado_id", "fecha", "hora_entrada"?, "hora_salida"?, "estado", "comentarios"? }` |

---

## 7. Procesamiento de Nómina (`/api/nominas`)

| Método | Endpoint | Descripción | Parámetros / Body Esperado |
| :--- | :--- | :--- | :--- |
| **GET** | `/nominas/proyectar` | Previsualiza los recibos calculados del período solicitado | Query params: `?periodo=Primera Quincena&mes=YYYY-MM` |
| **POST** | `/nominas/procesar` | Procesa, genera e históricamente cierra el lote de nómina | `{ "periodo": "Primera Quincena", "mes": "YYYY-MM", "tasa_cambio_ref"?: 45.50 }` |
| **GET** | `/nominas/historial` | Obtiene el listado consolidado de nóminas históricas | *Ninguno* |
| **GET** | `/nominas/recibos/{id}` | Obtiene los detalles de un recibo de pago por ID | *Ruta `id` (Ej: REC-WF1092-PRIMEQUINC-052026)* |
| **GET** | `/empleados/{id}/recibos` | Listado de recibos de nómina de un empleado específico | *Ruta `id` (Para panel de Autoservicio del Empleado)* |

---

## 8. Estadísticas para Reportes y Dashboard (`/api/dashboard`)

| Método | Endpoint | Descripción | Parámetros / Body Esperado |
| :--- | :--- | :--- | :--- |
| **GET** | `/dashboard/stats` | Obtiene el resumen general de KPIs para directivos | *Ninguno* |

### Respuesta JSON Exitosa Sugerida (`GET /dashboard/stats`)
```json
{
  "nominatotalUsd": 3150.00,
  "nominatotalVes": 143325.00,
  "asistenciaHoyPorcentaje": 80.0,
  "retardoHoyContador": 1,
  "ausentesHoyContador": 1,
  "totalEmpleadosActivos": 5
}
```

---

## Recomendación de Seguridad y Cabeceras

1. **Autenticación (Laravel Sanctum)**: Todas las rutas (a excepción de `/auth/login` y potencialmente `/asistencias/marcar` si se usa como kiosco de reloj de pared) deben estar protegidas usando el middleware `auth:sanctum`.
2. **Cabecera Requerida en Frontend**:
   ```http
   Accept: application/json
   Authorization: Bearer <token_obtenido>
   ```
