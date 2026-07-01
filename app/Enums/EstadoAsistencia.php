<?php

namespace App\Enums;

enum EstadoAsistencia: string
{
    case PRESENTE = 'Presente';
    case TARDE = 'Tarde';
    case AUSENTE = 'Ausente';
    case PERMISO_REPOSO = 'Permiso/Reposo';
}
