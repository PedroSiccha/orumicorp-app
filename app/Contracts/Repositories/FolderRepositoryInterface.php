<?php
namespace App\Contracts\Repositories;

use App\Models\Folder;
use Illuminate\Database\Eloquent\Collection;

interface FolderRepositoryInterface
{
    public function getAll(): Collection;
    public function getActiveFolders(): Collection;
    public function getFoldersByCategory(int $categoryId): Collection;
    public function disableFolder(Folder $folder): bool;
    public function assignClientsToFolder(int $folderId, array $clientsId): bool;
    public function save(array $data): Folder;
    public function findById(int $folderId): ?Folder;
    public function changeFolderCategory(int $folderId, int $categoryId): bool;
    public function update(Folder $folder, array $data): bool;
    public function delete(int $folderId): bool;
}
