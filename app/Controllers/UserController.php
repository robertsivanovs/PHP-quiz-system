<?php

declare(strict_types=1);

require_once './app/Models/User.php';

class UserController {

    private $userModel;
        
    /**
     * processUserData
     * 
     * Saves the user data to DB
     *
     * @param  mixed $username
     * @return int
     */
    public function processUserData($username = null): int {

        if (!$username) {
            return 0;
        }

        $this->userModel = new User();
        return (int)$this->userModel->createUser($username);

    }
}
