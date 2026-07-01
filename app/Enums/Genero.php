<?php

namespace App\Enums;

enum Genero: string
{
    case MASCULINO = 'Masculino';
    case FEMENINO = 'Femenino';
    case NO_BINARIO = 'No binario';
    case NO_DECIRLO = 'Prefiero no decirlo';
}
