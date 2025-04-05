<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\RepositoryException;
use App\Interfaces\FolderRepositoryInterface;
use App\Models\Customers;
use App\Models\Folder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class FolderRepository implements FolderRepositoryInterface
{
    public function getAll(): Collection
    {
        try {
            return Folder::all();
        } catch (QueryException $e) {
            Log::error('FolderRepository@getAll: ' . $e->getMessage());
            throw new RepositoryException('Error al obtener todas las carpetas.');
        }
    }

    public function getActiveFolders(): Collection
    {
        try {
            return Folder::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error('FolderRepository@getActiveFolders: ' . $e->getMessage());
            throw new RepositoryException('Error al obtener carpetas activas.');
        }
    }

    public function getFoldersByCategory(int $categoryId): Collection
    {
        try {
            return Folder::where('status', StatusEnum::ACTIVE->value)
                         ->where('category_id', $categoryId)
                         ->get();
        } catch (QueryException $e) {
            Log::error('FolderRepository@getFoldersByCategory: ' . $e->getMessage());
            throw new RepositoryException('Error al obtener carpetas por categoría.');
        }
    }

    public function disableFolder(Folder $folder): bool
    {
        try {
            return $folder->update(['status' => false]);
        } catch (QueryException $e) {
            Log::error('FolderRepository@disableFolder: ' . $e->getMessage());
            return false;
        }
    }

    public function assignClientsToFolder(int $folderId, array $clientsId): bool
    {
        try {
            Customers::whereIn('id', $clientsId)->update(['folder_id' => $folderId]);
            return true;
        } catch (QueryException $e) {
            Log::error('FolderRepository@assignClientsToFolder: ' . $e->getMessage());
            return false;
        }
    }

    public function save(array $data): Folder
    {
        try {
            return Folder::create($data);
        } catch (QueryException $e) {
            Log::error('FolderRepository@save: ' . $e->getMessage());
            throw new RepositoryException('Error al guardar carpeta.');
        }
    }

    public function findById(int $folderId): ?Folder
    {
        try {
            return Folder::find($folderId);
        } catch (QueryException $e) {
            Log::error('FolderRepository@findById: ' . $e->getMessage());
            throw new RepositoryException('Error al buscar carpeta por ID.');
        }
    }

    public function changeFolderCategory(int $folderId, int $categoryId): bool
    {
        try {
            return Folder::where('id', $folderId)
                         ->update(['category_id' => $categoryId]) > 0;
        } catch (QueryException $e) {
            Log::error('FolderRepository@changeFolderCategory: ' . $e->getMessage());
            return false;
        }
    }

    public function update(Folder $folder, array $data): bool
    {
        try {
            return $folder->update($data);
        } catch (QueryException $e) {
            Log::error('FolderRepository@update: ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $folderId): bool
    {
        try {
            return Folder::destroy($folderId) > 0;
        } catch (QueryException $e) {
            Log::error('FolderRepository@delete: ' . $e->getMessage());
            return false;
        }
    }
}
