<?php

namespace API\Service;

use API\Repository\UserRepository;

class UserService {

    private $userRepository;

    function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function authUser(string $login, string $pass) {
        if ($user = $this->userRepository->userVerify($login, $pass)) {
            return $user;
        }
    }
    
}
