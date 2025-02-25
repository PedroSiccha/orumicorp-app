<?php
namespace App\Interfaces;

use App\Http\Requests\SaveUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function createUser(SaveUserRequest $data): ?User;

}
