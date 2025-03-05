<?php
namespace App\Enums;

enum ActionType: int
{
    case VENTA = 1;
    case BONUS = 2;
    case PERSONALIZACION = 3;
    case RETIRO = 4;
}
