<?php
namespace App\Contracts\Repositories;

use App\Models\CategoryFolder;
use Illuminate\Database\Eloquent\Collection;

interface CategoryFolderRepositoryInterface
{
    public function getAll(): Collection;
    public function getAllActive(): Collection;
    public function save(array $data): CategoryFolder;
}
