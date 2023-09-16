<?php

use app\Classes\Database;

/**
 * Test (Quiz) model
 */
require_once './app/Classes/Database.php';

class Test extends Database
{
    public function __construct()
    {
        parent::__construct(); // Call the parent constructor
    }
    
    /**
     * getTests
     *
     * @return array
     * @throws PDOException
     */
    public function getTests()
    {
        try {
            $sql = "SELECT id, title FROM tests";
            $stmt = $this->con->prepare($sql);
            $result = $stmt->execute();
            $result = $stmt->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return $result;
    }
}
