<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;

class DateService
{
    /**
     * Formatea una fecha dada o retorna un mensaje de error si es inválida.
     *
     * @param string|null $date
     * @param string $format
     * @return string
     */
    public function formatDate(?string $date, string $format = 'd/m/Y'): string
    {
        if (empty($date)) {
            return 'Fecha no disponible';
        }

        try {
            return Carbon::parse($date)->format($format);
        } catch (Exception $e) {
            return 'Fecha inválida';
        }
    }
}
