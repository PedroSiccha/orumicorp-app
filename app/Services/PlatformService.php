<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\PlatformRequest;
use App\Http\Requests\StorePlatformRequest;
use App\Interfaces\PlatformRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
            $dataPlatform = new StorePlatformRequest([
                'name' => $request->name,
                'description' => $request->description,
                'status' => StatusEnum::ACTIVE->value
            ]);
            $platform = $this->platformRepository->savePlatform($dataPlatform);
            $platforms = $this->platformRepository->getPlatforms();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $platforms]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function updatePlatform($request)
    {

        try {
            $platform = $this->platformRepository->findPlatformById($request->id);
            $dataPlatform = new StorePlatformRequest([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            $response = $this->platformRepository->updatePlatform($platform, $dataPlatform);
            $platforms = $this->platformRepository->getPlatforms();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $platforms]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function deletePlatform($request)
    {
        try {
            $platform = $this->platformRepository->findPlatformById($request->id);
            $response = $this->platformRepository->deletePlatform($platform->id);
            $platforms = $this->platformRepository->getPlatforms();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $platforms]);
        } catch (ValidationException $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }
}