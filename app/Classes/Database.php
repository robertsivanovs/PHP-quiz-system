<?php

declare (strict_types=1);
namespace app\Classes;

use PDO;
use PDOException;

/**
 * Database class @author Roberts Ivanovs
 * Used for establishing a connection to the database
 */
class Database
{
    /**
     * Constructor
     *
     * This constructor is executed when creating a new object.
     * It establishes a connection to the database.
     * 
     * Throws a PDO exception if the connection fails.
     * 
     * @throws PDOException If the database connection fails.
     */
    public function __construct(
        private string $serverName = "",
        private string $username = "",
        private string $password = "",
        private string $dbname = "",
        public $con = null
    )
    {
        try {
            // Create a PDO database connection with specified settings.
            $this->con = new PDO("mysql:host=$this->serverName;dbname=$this->dbname; charset=UTF8", $this->username, $this->password);

            // Set PDO error mode to throw exceptions for better error handling.
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Set the default fetch mode to associative arrays for result sets.
            $this->con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // Disable emulated prepared statements for security.
            $this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            // Return the PDO exception message if the connection fails.
            echo "Database connection failed: " . $e->getMessage();
        }
    }
}
