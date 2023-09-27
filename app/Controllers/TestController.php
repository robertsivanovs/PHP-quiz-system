<?php

declare(strict_types=1);
require_once './app/Models/Test.php';

/**
 * TestController class @author Roberts Ivanovs
 * Handles all actions related to the quiz
 */
class TestController 
{
    public function __construct(
        private $testModel = new Test()
    ) {}

    /**
     * Fetches the list of all tests from the DB.
     *
     * @return array
     */
    public function getTestList(): array 
    {
        return $this->testModel->getTests() ?? [];
    }

    /**
     * Fetches current question and its answers from DB.
     *
     * @param mixed $userTest
     * @param mixed $questionPosition
     * @return array
     */
    public function getQuestionData(?int $userTest = null, ?int $questionPosition = null): array 
    {
        // Validate if the values are integers, log the error if not
        if (gettype($userTest) != "integer" || gettype($questionPosition) != "integer") {
            error_log(
                "Error in getQuestionData(): TestID or QuestionPos is not integer" . "\n", 3, 
                "error.log"
            );
            return [];
        }

        return $this->testModel->getQuestionData($userTest, $questionPosition) ?: [];
    }

    /**
     * Saves user provided answers to DB.
     *
     * @param mixed $userID
     * @param mixed $questionID
     * @param mixed $answerID
     * @return int
     */
    public function saveUserResponses(?int $userID = null, ?int $questionID = null, ?int $answerID = null): int 
    {
        // Validate if the values are integers, log the error if not
        if (
            gettype($userID) != "integer" || 
            gettype($questionID) != "integer" ||
            gettype($answerID) != "integer"
        ) {
            error_log(
                "Error in saveUserResponses(): UserID, QuestionID or AnswerID is not integer" . "\n", 3, 
                "error.log"
            );
            return 0;
        }

        return (int)$this->testModel->saveQuestionAnswer($userID, $questionID, $answerID);
    }

    /**
     * Returns total question count in the current test.
     *
     * @param mixed $testID
     * @return int
     */
    public function getQuestionCount(?int $testID = null): int 
    {        
        // Validate if the values are integers, log the error if not
        if (gettype($testID) != "integer") {
            error_log(
                "Error in getQuestionCount(): TestID is not integer" . "\n", 3, 
                "error.log"
            );
            return 0;
        }

        return (int)$this->testModel->getTestQuestionCount($testID);
    }

    /**
     * Returns correct answer count for the current user.
     *
     * @param mixed $userID
     * @return int
     */
    public function getCorrectAnswerCount(?int $userID = null): int 
    {
        // Validate if the values are integers, log the error if not
        if (gettype($userID) != "integer") {
            error_log(
                "Error in getCorrectAnswerCount(): TestID is not integer" . "\n", 3, 
                "error.log"
            );
            return 0;
        }

        return (int)$this->testModel->getCorrectUserAnswers($userID);
    }
    
    /**
     * saveFinalResult
     * 
     * Saves the final test result to DB
     *
     * @param mixed $userID
     * @param mixed $testID
     * @param mixed $correctAnswers
     * @return int
     */
    public function saveFinalResult(?int $userID = null, ?int $testID = null, ?int $correctAnswers = null): int
    {
        // Validate if the values are integers, log the error if not
        if (
            gettype($userID) != "integer" || 
            gettype($testID) != "integer" ||
            gettype($correctAnswers) != "integer"
        ) {
            error_log(
                "Error in saveFinalResult(): UserID, testID or correctAnswers is not integer" . "\n", 3, 
                "error.log"
            );
            return 0;
        }

        return (int)$this->testModel->saveFinalResult($userID, $testID, $correctAnswers);

    }
}
