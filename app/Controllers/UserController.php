<?php

require_once './app/Models/User.php';

class UserController {

    private $userModel;
        
    /**
     * processUserData
     *
     * @param  mixed $username
     * @return bool
     */
    public function processUserData($username = null) {

        if (!$username) {
            return false;
        }

        $this->userModel = new User();
        return $this->userModel->createUser($username);

    }
}