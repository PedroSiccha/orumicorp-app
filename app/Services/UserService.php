<?php
namespace App\Services;

use App\Interfaces\UserInterface;
use App\Interfaces\UserRepositoryInterface;

class UserService implements UserInterface {

    protected $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function validateSession() {
        $user = $this->userRepository->getCurrentUser();

        if ($user === null) {
            return null;
        } else {
            return redirect('/login');
        }
    }
}
