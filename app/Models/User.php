<?php

declare(strict_types=1);
use app\Classes\Database;
require_once './app/Classes/Database.php';

/**
 * User model @author Roberts Ivanovs
 * Executes the required SQL queries for saving the user data to database
 */
class User extends Database
{
    /**
     * createUser
     * 
     * Saves user data to DB
     *
     * @param String $username
     * @return int
     */
    public function createUser(string $username): int 
    {
        try {
            $sql = "INSERT INTO users (username) VALUES (:username)";
            $stmt = $this->con->prepare($sql);
            $result = $stmt->execute([':username' => $username]);

            if ($result) {
                // Return the ID of the newly created record
                return (int)$this->con->lastInsertId();
            } else {
                return 0; // Failed to insert the user
            }
        } catch (PDOException $e) {
            // Log the error
            error_log("Error in createUser(): " . $e->getMessage(), 3, "error.log");
            return 0;
        }
    }
}
