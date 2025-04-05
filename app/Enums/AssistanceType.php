<?php
namespace App\Enums;

enum AssistanceType: string
{
    case INGRESO = 'IN';
    case INGRESO_BREAK = 'IN-BREAK';
    case VUELTA_BREAK = 'OUT-BREAK';
    case SALIDA = 'OUT';
    case VACATION = 'VACATION';
}
