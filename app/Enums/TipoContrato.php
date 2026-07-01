<?php

namespace App\Enums;

enum TipoContrato: string
{
    case TIEMPO_INDETERMINADO = 'Tiempo Indeterminado';
    case TIEMPO_DETERMINADO = 'Tiempo Determinado';
    case POR_OBRA = 'Por Obra';
    case FREELANCE = 'Freelance';
}
