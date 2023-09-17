<?php

declare(strict_types=1);


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
    public function getTestList(): array {

        $this->testModel = new Test;
        $result = $this->testModel->getTests();
        return $result;

    }
    
    /**
     * getTestData
     *
     * @param  mixed $userTest
     * @param  mixed $questionPosition
     * @return array
     */
    public function getTestData($userTest = null, $questionPosition = null): array {

        $data = [];

        if (!$userTest || !$questionPosition) {
            return $data;
        }

        $this->testModel = new Test;
        return $data = $this->testModel->getTestData($userTest, $questionPosition);
    }
}