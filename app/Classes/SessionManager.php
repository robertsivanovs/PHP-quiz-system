<?php

declare (strict_types=1);
namespace app\Classes;

/**
 * SessionManager
 * 
 * Class for managing session data and security
 * 
 */
class SessionManager 
{
    // Session variables that need to be set for the user to be able to procceed
    protected array $sessionVariables = [
        'username',
        'user_test_id',
        'user_id',
        'current_question'
    ];

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        session_start();
        session_regenerate_id(true); // For additional security
        $this->configureSession();
    }

    private function configureSession(): void
    {
        // Configure your session settings here
        ini_set('session.cookie_httponly', true);
        ini_set('session.use_only_cookies', true);
        ini_set('session.use_strict_mode', true);
        // Add more session configuration options as needed
    }
    
    /**
     * setSessionVariable
     * 
     * Set session variables
     *
     * @param  array $values
     * @return void
     */
    public function setSessionVariable(array $values): void
    {
        foreach ($values as $name => $value) {
            $_SESSION[$name] = $value;
        }
    }
    
    /**
     * getSessionVariable
     * 
     * Returns session variables
     *
     * @param  mixed $variable
     * @return mixed
     */
    public function getSessionVariable(?string $variable): mixed
    {
        return $_SESSION[$variable] ?? null;
    }
    
    /**
     * checkSessionVariables
     * 
     * Checks if the required variables are stored in the session
     *
     * @return bool
     */
    public function checkSessionVariables(): bool
    {
        foreach ($this->sessionVariables as $variable) {
            if (!$this->getSessionVariable($variable)) {
                return false;
            }
        }

        return true;
    }
    
    /**
     * destroySession
     * 
     * Destroys current user session
     *
     * @return void
     */
    public function destroySession()
    {
        session_destroy();
    }

}
