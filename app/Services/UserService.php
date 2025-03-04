<?php
namespace App\Services;

use App\Interfaces\UserInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserService implements UserInterface {

    protected $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function validateSession() {
        $user = $this->userRepository->getUser();

        if ($user === null) {
            return null;
        } else {
            return redirect('/login');
        }
    }
}
