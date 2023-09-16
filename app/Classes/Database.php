<?php

namespace app\Classes;

use PDO;

/**
 * database class @author Roberts Ivanovs
 * Tiek veidota, lai izveidotu veiksmīgu savienojumu ar datubāzi.
 */
class Database
{

    public $serverName = "localhost";
    public $username = "debian-sys-maint";
    public $password = "AaXz923xselSfJAz";
    public $dbname = "php_quiz";
    public $con;

    /**
     * __construct
     *
     * Konstruktors, tiek izpildīts veidojot jaunu objektu.
     * Pie izpildes tiek veidots savienojums ar datubāzi.
     * 
     * Atgriež PDO kļūdas paziņojumu, ja savienojums nav izdevies.
     * 
     * @throws PDOException $e
     * @return void
     */
    public function __construct()
    {
        try {
            $this->con = new PDO("mysql:host=$this->serverName;dbname=$this->dbname; charset=UTF8", $this->username, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}