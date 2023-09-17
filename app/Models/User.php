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
     * @return bool
     */
    public function createUser(string $username) {
        try {
            $sql = "INSERT INTO users (username) VALUES (:username)";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':username', $username);
            $result = $stmt->execute();

            if ($result) {
                // Return the ID of the newly created record
                return $this->con->lastInsertId();
            } else {
                return false; // Failed to insert the user
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}