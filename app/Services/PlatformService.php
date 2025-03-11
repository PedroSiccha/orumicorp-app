<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Interfaces\PlatformRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class PlatformService
{

    protected $platformRepository;

    public function __construct(
        PlatformRepositoryInterface $platformRepository
    ) {
        $this->platformRepository = $platformRepository;
    }

    public function savePlatform($request)
    {
        try {
            $dataPlatform = [
                'name' => $request->name,
                'description' => $request->description,
                'status' => StatusEnum::ACTIVE->value
            ];
            $platform = $this->platformRepository->save($dataPlatform);
            $platforms = $this->platformRepository->getActivePlatforms();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $platforms]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function updatePlatform($request)
    {

        try {
            $platform = $this->platformRepository->findById($request->id);
            $dataPlatform = [
                'name' => $request->name,
                'description' => $request->description,
            ];
            $response = $this->platformRepository->update($platform, $dataPlatform);
            $platforms = $this->platformRepository->getActivePlatforms();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $platforms]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function deletePlatform($request)
    {
        try {
            $platform = $this->platformRepository->findById($request->id);
            $response = $this->platformRepository->delete($platform->id);
            $platforms = $this->platformRepository->getActivePlatforms();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $platforms]);
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }
}