<?php
namespace App\Repositories;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\RepositoryException;
use App\Http\Requests\StoreFolderRequest;
use App\Interfaces\FolderRepositoryInterface;
use App\Models\Customers;
use App\Models\Folder;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class FolderRepository implements FolderRepositoryInterface
{
    public function getAllFolders(): Collection
    {
        try {
            return Folder::all();
        } catch (QueryException $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getFolders(): Collection
    {
        try {
            return Folder::where('status', StatusEnum::ACTIVE->value)->get();
        } catch (QueryException $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function getFoldersByCategory(int $categoryId): Collection
    {
        try {
            return Folder::where('status', 1)->where('category_id', 1)->get();
        } catch (QueryException $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function disableFolder(Folder $folder): bool
    {
        try {
                $folder->status = false;
                if (!$folder->save()) {
                    return false;
                }
                return true;
        } catch (QueryException $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            return false;
        }
    }

    public function assignClientToFolder(int $folderId, array $clientsId): bool
    {
        try {
            foreach ($clientsId as $idClient) {
                $client = Customers::find($idClient);
                if (!$client) {
                    Log::warning("Cliente con ID {$idClient} no encontrado.");
                    continue;
                }
                $client->folder_id = $folderId;
                $client->save();
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            return false;
        }
    }

    public function saveFolder(StoreFolderRequest $data): Folder
    {
        try {
            return Folder::create($data);
        } catch (QueryException $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function findFolderById(int $folderId): ?Folder
    {
        try {
            return Folder::find($folderId);
        } catch (QueryException $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        } catch (Exception $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            throw new Exception("No se encontraron resultados para los filtros aplicados.");
        }
    }

    public function changeFolderCategory(int $folderId, StoreFolderRequest $data): bool{
        try {
            $folder = Folder::find($folderId);
            $folder->category_id = $data->categoryId;
            if (!$folder->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            return false;
        }
    }

    public function updateFolder(Folder $folder, StoreFolderRequest $data): bool
    {
        try {
            $folder->fill($data->validated());
            if (!$folder->save()) {
                return false;
            }
            return true;
        } catch (QueryException $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::error("Error FolderRepository: " . $e->getMessage());
            return false;
        }
    }

}
