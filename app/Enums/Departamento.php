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
