<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Http\Requests\SaveCategoryFolderRequest;
use App\Interfaces\CategoryFolderRepositoryInterface;
use App\Models\CategoryFolder;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class CategoryFolderRepository implements CategoryFolderRepositoryInterface
{
    public function getAllCategoryFolders(): Collection
    {
        try {
            return CategoryFolder::all();
        } catch (QueryException $e) {
            Log::error("Error CategoryFolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error CategoryFolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getCategoryFolders(): Collection
    {
        try {
            return CategoryFolder::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error("Error CategoryFolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error CategoryFolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function saveCategoryFolder(SaveCategoryFolderRequest $data): ?CategoryFolder
    {
        try {
            return CategoryFolder::create($data);
        } catch (QueryException $e) {
            Log::error("Error CategoryFolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error CategoryFolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

}
