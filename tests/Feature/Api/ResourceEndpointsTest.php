<?php

namespace Tests\Feature\Api;

use App\Models\Empresa;
use App\Models\Empleado;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourceEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_empleados_endpoints_work(): void
    {
        $empresa = Empresa::create([
            'nombre_comercial' => 'Empresa Test',
            'razon_social' => 'Empresa Test C.A.',
            'rif' => 'J-12345678-9',
            'direccion_fiscal' => 'Av. Principal',
            'telefono' => '02121234567',
            'correo_contacto' => 'rrhh@test.com',
            'representante_legal' => 'Juan Pérez',
            'activa' => true,
        ]);

        $payload = [
            'empresa_id' => $empresa->id,
            'codigo_empleado' => 'EMP-001',
            'nombre_completo' => 'Ana López',
            'fecha_nacimiento' => '1990-01-15',
            'genero' => 'Femenino',
            'cedula_identidad' => 'V-12345678',
            'rif' => 'J-87654321-0',
            'fecha_inicio' => '2020-01-01',
            'departamento' => 'Recursos Humanos',
            'cargo' => 'Analista',
            'correo_trabajo' => 'ana@test.com',
            'telefono' => '04121234567',
            'contacto_emergencia' => 'María López - 04123456789',
            'tipo_contrato' => 'Tiempo Indeterminado',
            'tipo_concepto' => 'Sueldo Base',
            'monto_sueldo_usd' => 1200.50,
            'frecuencia_pago' => 'Mensual',
            'activo' => true,
        ];

        $createResponse = $this->postJson('/api/empleados', $payload);
        $createResponse->assertStatus(201)
            ->assertJsonPath('data.codigo_empleado', 'EMP-001');

        $this->assertDatabaseHas('empleados', ['codigo_empleado' => 'EMP-001']);

        $listResponse = $this->getJson('/api/empleados');
        $listResponse->assertStatus(200)
            ->assertJsonFragment(['codigo_empleado' => 'EMP-001']);

        $empleado = Empleado::where('codigo_empleado', 'EMP-001')->firstOrFail();

        $showResponse = $this->getJson('/api/empleados/' . $empleado->id);
        $showResponse->assertStatus(200)
            ->assertJsonPath('data.codigo_empleado', 'EMP-001');

        $updateResponse = $this->putJson('/api/empleados/' . $empleado->id, [
            'cargo' => 'Coordinador',
            'activo' => true,
        ]);
        $updateResponse->assertStatus(200)
            ->assertJsonPath('data.cargo', 'Coordinador');

        $deleteResponse = $this->deleteJson('/api/empleados/' . $empleado->id);
        $deleteResponse->assertStatus(200);
        $this->assertDatabaseMissing('empleados', ['id' => $empleado->id]);
    }

    public function test_empresas_endpoints_work(): void
    {
        $payload = [
            'nombre_comercial' => 'Empresa Demo',
            'razon_social' => 'Empresa Demo C.A.',
            'rif' => 'J-11111111-1',
            'direccion_fiscal' => 'Calle Falsa 123',
            'telefono' => '02121111111',
            'correo_contacto' => 'demo@empresa.com',
            'representante_legal' => 'Carlos Gómez',
            'activa' => true,
        ];

        $createResponse = $this->postJson('/api/empresas', $payload);
        $createResponse->assertStatus(201)
            ->assertJsonPath('data.nombre_comercial', 'Empresa Demo');

        $this->assertDatabaseHas('empresas', ['rif' => 'J-11111111-1']);

        $listResponse = $this->getJson('/api/empresas');
        $listResponse->assertStatus(200)
            ->assertJsonFragment(['nombre_comercial' => 'Empresa Demo']);

        $empresa = Empresa::where('rif', 'J-11111111-1')->firstOrFail();

        $showResponse = $this->getJson('/api/empresas/' . $empresa->id);
        $showResponse->assertStatus(200)
            ->assertJsonPath('data.nombre_comercial', 'Empresa Demo');

        $updateResponse = $this->putJson('/api/empresas/' . $empresa->id, [
            'nombre_comercial' => 'Empresa Demo Actualizada',
        ]);
        $updateResponse->assertStatus(200)
            ->assertJsonPath('data.nombre_comercial', 'Empresa Demo Actualizada');

        $deleteResponse = $this->deleteJson('/api/empresas/' . $empresa->id);
        $deleteResponse->assertStatus(200);
        $this->assertDatabaseMissing('empresas', ['id' => $empresa->id]);
    }
}
