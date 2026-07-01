<?php

namespace App\Enums;

enum TipoBancoCuenta: string
{
    case CORRIENTE = 'Corriente';
    case AHORRO = 'Ahorro';
}
