<?php
namespace App\Services;

use App\Interfaces\RolesInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RolesService implements RolesInterface {

    public function __construct() {}

    public function getMyRoles() {
        $user_id = Auth::user()->id;

        if ($user_id) {
            $user = User::find($user_id);
            if ($user) {
                $rolesId = $user->roles()->pluck('id')->first();
                $roles = $user->getRoleNames()->first();
                if ($roles) {
                    return [
                        'roles' => $roles,
                        'rolesId' => $rolesId
                    ];
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } else {
            return null;
        }

    }
}
