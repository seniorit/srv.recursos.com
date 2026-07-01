<?php

namespace App\Enums;

enum EstadoPago: string
{
    case PENDIENTE = 'Pendiente';
    case PROCESADO = 'Procesado';
    case FALLIDO = 'Fallido';
}
