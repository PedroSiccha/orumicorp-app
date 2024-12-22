<?php
namespace App\Services;

use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Auth;

class UserService implements UserInterface {
    public function __construct() {}

    public function validateSession() {
        $user = Auth::user();

        if ($user === null) {
            return null;
        } else {
            return redirect('/login');
        }
    }
}
