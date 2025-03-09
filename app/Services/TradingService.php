<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreTraidingRequest;
use App\Interfaces\TraidingRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TradingService
{

    protected $traidingRepository;

    public function __construct(
        TraidingRepositoryInterface $traidingRepository
    ) {
      $this->traidingRepository = $traidingRepository;  
    }

    public function saveTraiding($request)
    {
        $dataTraiding = new StoreTraidingRequest([
            'code' => $request->code,
            'description' => $request->description,
            'status' => StatusEnum::ACTIVE->value
        ]);
        DB::beginTransaction();
        try {
            $response = $this->traidingRepository->saveTraiding($dataTraiding);
            DB::commit();
            $traidings = $this->traidingRepository->getTraidings();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $traidings]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function updateTraiding($request)
    {
        $dataTraiding = new StoreTraidingRequest([
            'code' => $request->code,
            'description' => $request->description,
            'status' => $request->status
        ]);
        $traiding = $this->traidingRepository->findTraidingById($request->traidingId);
        DB::beginTransaction();
        try {
            $response = $this->traidingRepository->updateTraiding($traiding, $dataTraiding);
            DB::commit();
            $traidings = $this->traidingRepository->getTraidings();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $traidings]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }

    public function deleteTraiding(int $traidingId)
    {
        DB::beginTransaction();
        try {
            $response = $this->traidingRepository->deleteTraiding($traidingId);
            DB::commit();
            $traidings = $this->traidingRepository->getTraidings();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $traidings]);
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }
}