<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\PercentRepositoryInterface;
use App\Models\Percent;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class PercentRepository implements PercentRepositoryInterface
{
    public function getActivePercents(): Collection
    {
        try {
            return Percent::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error('PercentRepository@getActivePercents: ' . $e->getMessage());
            throw new Exception('Error al obtener porcentajes activos.');
        }
    }

    public function getAllPercents(): Collection
    {
        try {
            return Percent::all();
        } catch (QueryException $e) {
            Log::error('PercentRepository@getAllPercents: ' . $e->getMessage());
            throw new Exception('Error al obtener todos los porcentajes.');
        }
    }
}
