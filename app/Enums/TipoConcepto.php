<?php

namespace App\Enums;

enum TipoConcepto: string
{
    case SUELDO_BASE = 'Sueldo Base';
    case HONORARIOS_PROFESIONALES = 'Honorarios Profesionales';
    case BONO_FIJO = 'Bono Fijo';
}
