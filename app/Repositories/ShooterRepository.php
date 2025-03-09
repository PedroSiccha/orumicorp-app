<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Http\Requests\StoreShooterRequest;
use App\Interfaces\ShooterRepositoryInterface;
use App\Models\Shooter;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ShooterRepository implements ShooterRepositoryInterface
{
    public function getShooter(): ?Shooter
    {
        try {
             return Shooter::where('status', StatusEnum::ACTIVE->value)->first();
        } catch (QueryException $e) {
            Log::error("Error ShooterRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ShooterRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveShooter(StoreShooterRequest $data): Shooter
    {
        try {
            return Shooter::create($data);
        } catch (QueryException $e) {
            Log::error("Error ShooterRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ShooterRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function disableShooter(Shooter $shooter): bool
    {
        try {
            $shooter->end = Carbon::now();
            $shooter->status = false;
            if (!$shooter->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error ShooterRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error ShooterRepository: " . $e->getMessage());
            return false;
        }
    }

    public function findShooterById(int $shooterId): ?Shooter
    {
        try {
            return Shooter::find($shooterId);
        } catch (QueryException $e) {
            Log::error("Error ShooterRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error ShooterRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }
}
