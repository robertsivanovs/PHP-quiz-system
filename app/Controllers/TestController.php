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
     * Fetches current question and its answers from DB
     *
     * @param  mixed $userTest
     * @param  mixed $questionPosition
     * @return array
     */
    public function getQuestionData($userTest = null, $questionPosition = null): array {

        $data = [];

        if (!$userTest || !$questionPosition) {
            return $data;
        }

        $this->testModel = new Test;

        if ($this->testModel->getQuestionData($userTest, $questionPosition)) {
            return $data = $this->testModel->getQuestionData($userTest, $questionPosition);
        }
        
        return $data;
    }
    
    /**
     * saveUserResponses
     * 
     * Saves user provided answers to DB
     *
     * @param  mixed $userID
     * @param  mixed $questionID
     * @param  mixed $answerID
     * @return int
     */
    public function saveUserResponses($userID = null, $questionID = null, $answerID = null): int {

        if (!$userID || !$questionID || !$answerID) {
            return 0;
        }

        $this->testModel = new Test;
        return (int)$this->testModel->saveQuestionAnswer($userID, $questionID, $answerID);

    }

    public function getQuestionCount($testID = null) {
        $this->testModel = new Test;
        return $this->testModel->getTestQuestionCount($testID);
    }

    public function getCorrectAnswerCount($userID = null) {
        $this->testModel = new Test;
        return $this->testModel->getCorrectUserAnswers($userID);

    }
}