<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
use App\Http\Requests\SaveCategoryFolderRequest;
use App\Interfaces\CategoryFolderRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryFolderService
{

    protected $categoryFolderRepository;

    public function __construct(
        CategoryFolderRepositoryInterface $categoryFolderRepository
    ) {
        $this->categoryFolderRepository = $categoryFolderRepository;
    }

    public function saveCategoryFolder($request)
    {
        DB::beginTransaction();
        try {
            $$dataCategoryFolder = new SaveCategoryFolderRequest([
                'name' => $request->name,
                'status' => StatusEnum::ACTIVE->value
            ]);
            $categoryFolder = $this->categoryFolderRepository->saveCategoryFolder($dataCategoryFolder);
            DB::commit();
            return ResponseHelper::success('Se cambió el estado del agente correctamente.', ['response' => $categoryFolder]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en ClientService: " . $e->getMessage());
            return ResponseHelper::error('Error al cambiar el estado del agente.');
        }
    }
}