<?php

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
     *
     * @param  String $username
     *
     * @return void
     */
    public function createUser($username)
    {
        try {
            $sql = "INSERT INTO users (username) VALUES (:username)";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':username', $username);
            $result = $stmt->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        return $result;
    }
}