<?php

namespace App\Enums;

enum MetodoPago: string
{
    case PAGO_MOVIL = 'Pago Móvil';
    case TRANSFERENCIA = 'Transferencia';
    case EFECTIVO = 'Efectivo';
}
