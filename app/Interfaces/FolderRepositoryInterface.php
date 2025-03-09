<?php
namespace App\Interfaces;

use App\Http\Requests\StoreFolderRequest;
use App\Models\Folder;
use Illuminate\Database\Eloquent\Collection;

interface FolderRepositoryInterface
{
    public function getAllFolders(): Collection;
    public function getFolders(): Collection;
    public function getFoldersByCategory(int $categoryId): Collection;
    public function disableFolder(Folder $folder): bool;
    public function assignClientToFolder(int $folderId, array $clientsId): bool;
    public function saveFolder(StoreFolderRequest $data): Folder;
    public function findFolderById(int $folderId): ?Folder;
    public function changeFolderCategory(int $folderId, StoreFolderRequest $data): bool;
    public function updateFolder(Folder $folder, StoreFolderRequest $data): bool;
}
