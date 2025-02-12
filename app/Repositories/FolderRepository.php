<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\RepositoryException;
use App\Interfaces\FolderRepositoryInterface;
use App\Models\Folder;
use Exception;

class FolderRepository implements FolderRepositoryInterface
{
    public function getAllFolders(): Collection
    {
        try {
            return Folder::all();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener las carpetas: " . $e->getMessage());
        }
    }

    public function getActiveFolders(): Collection
    {
        try {
            return Folder::where('status', true)->get();
        } catch (Exception $e) {
            throw new RepositoryException("Error al obtener las carpetas: " . $e->getMessage());
        }

    }

}
