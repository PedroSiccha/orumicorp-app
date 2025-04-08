<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Contracts\Repositories\ShooterRepositoryInterface;
use App\Models\Shooter;
use Exception;
use Illuminate\Support\Facades\Log;

class ShooterRepository implements ShooterRepositoryInterface
{
    public function getShooter(): ?Shooter
    {
        try {
            return Shooter::where('status', StatusEnum::ACTIVE->value)->first();
        } catch (Exception $e) {
            Log::error("Error obteniendo Shooter activo: " . $e->getMessage());
            throw new Exception("Error al obtener datos.");
        }
    }

    public function saveShooter(array $data): Shooter
    {
        try {
            return Shooter::create($data);
        } catch (Exception $e) {
            Log::error("Error guardando Shooter: " . $e->getMessage());
            throw new Exception("Error al guardar datos.");
        }
    }

    public function disableShooter(Shooter $shooter): bool
    {
        try {
            $shooter->end = now();
            $shooter->status = StatusEnum::INACTIVE->value;
            return $shooter->save();
        } catch (Exception $e) {
            Log::error("Error desactivando Shooter: " . $e->getMessage());
            return false;
        }
    }

    public function findShooterById(int $shooterId): ?Shooter
    {
        try {
            return Shooter::find($shooterId);
        } catch (Exception $e) {
            Log::error("Error buscando Shooter por ID: " . $e->getMessage());
            throw new Exception("Error al obtener datos.");
        }
    }
}
