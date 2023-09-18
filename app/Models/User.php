<?php

declare(strict_types=1);

use app\Classes\Database;

/**
 * User model @author Roberts Ivanovs
 */
require_once './app/Classes/Database.php';

class User extends Database
{
    /**
     * createUser
     * 
     * Saves the user data to DB
     *
     * @param  String $username
     *
     * @return int
     * @throws PDOException
     */
    public function createUser(string $username): int {

        try {
            $sql = "INSERT INTO users (username) VALUES (:username)";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':username', $username);
            $result = $stmt->execute();

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
