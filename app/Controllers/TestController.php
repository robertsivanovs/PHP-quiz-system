<?php

require_once './app/Models/Test.php';

class TestController {

    private $testModel;
    
    /**
     * getTestList
     * 
     * Fetches the list of all tests from the DB
     *
     * @return array
     */
    public function getTestList() {

        $this->testModel = new Test;
        $result = $this->testModel->getTests();
        return $result;

    }
}