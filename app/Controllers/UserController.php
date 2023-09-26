<?php

declare(strict_types=1);
require_once './app/Models/User.php';

/**
 * UserController class @author Roberts Ivanovs
 * Processes user registration
 */
class UserController 
{
    public function __construct(
        private User $userModel = new User()
    ) {}
        
    /**
     * processUserData
     * 
     * Saves the user data to DB
     *
     * @param string|null $username
     * @return int
     */
    public function processUserData(?string $username = null): int 
    {
        if (!$username) {
            return 0;
        }

        return (int)$this->userModel->createUser($username);
    }
}
