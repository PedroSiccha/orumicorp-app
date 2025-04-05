<?php
namespace App\Services;

use App\Enums\StatusEnum;
use App\Helpers\ResponseHelper;
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

    public function saveCategoryFolder(array $data)
    {
        DB::beginTransaction();
        try {
            $categoryFolderData = [
                'name' => $data['name'],
                'status' => StatusEnum::ACTIVE->value
            ];

            $categoryFolder = $this->categoryFolderRepository->save($categoryFolderData);
            DB::commit();

            return ResponseHelper::success('Categoría de carpeta guardada correctamente.', [
                'response' => $categoryFolder
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error en saveCategoryFolder: " . $e->getMessage());
            return ResponseHelper::error('Error al guardar la categoría de carpeta.');
        }
    }
}