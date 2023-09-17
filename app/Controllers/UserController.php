<?php

require_once './app/Models/User.php';

class UserController {

    private $userModel;
        
    /**
     * processUserData
     * 
     * Saves the user data to DB
     *
     * @param  mixed $username
     * @return bool
     */
    public function processUserData($username = null): bool {

        if (!$username) {
            return false;
        }

        $this->userModel = new User();
        return $this->userModel->createUser($username);

    }
}