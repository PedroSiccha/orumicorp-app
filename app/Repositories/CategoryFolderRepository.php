<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Interfaces\CategoryFolderRepositoryInterface;
use App\Models\CategoryFolder;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class CategoryFolderRepository implements CategoryFolderRepositoryInterface
{
    public function getAll(): Collection
    {
        try {
            return CategoryFolder::all();
        } catch (QueryException $e) {
            Log::error('CategoryFolderRepository@getAll: ' . $e->getMessage());
            throw new Exception('Error al obtener categorías de carpetas.');
        }
    }

    public function getAllActive(): Collection
    {
        try {
            return CategoryFolder::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error('CategoryFolderRepository@getAllActive: ' . $e->getMessage());
            throw new Exception('Error al obtener categorías activas.');
        }
    }

    public function save(array $data): CategoryFolder
    {
        try {
            return CategoryFolder::create($data);
        } catch (QueryException $e) {
            Log::error('CategoryFolderRepository@save: ' . $e->getMessage());
            throw new Exception('Error al guardar categoría de carpeta.');
        }
    }
}
