<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface FolderRepositoryInterface
{
    public function getAllFolders(): Collection;
    public function getActiveFolders(): Collection;
}
