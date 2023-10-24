<?php

declare(strict_types=1);

require_once './app/Models/Test.php';
require_once './app/Classes/Validator.php';


ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

/**
 * TestController class @author Roberts Ivanovs
 * Handles all actions related to the quiz
 */
class TestController 
{    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private $testModel = new Test(),
        private $validator = new Validator()
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
     * @param mixed $userTestId
     * @param mixed $questionPosition
     * @return array
     */
    public function getQuestionData(?int $userTestId = null, ?int $questionPosition = null): array 
    {
        // Validation
        $this->validator->setField("User Test ID")->setValue($userTestId)->checkEmpty()->isInteger();
        $this->validator->setField("Question Position")->setValue($questionPosition)->checkEmpty()->isInteger();

        // Validate the values, log the error if not
        if (!$this->validator->valid()) {
            error_log(
                "Error in getQuestionData(): " . $this->validator->getErrors() . "\n", 3, 
                "error.log"
            );

            return [];
        }

        return $this->testModel->getQuestionData($userTestId, $questionPosition) ?: [];
    }

    /**
     * Saves user provided answers to DB.
     *
     * @param mixed $userId
     * @param mixed $questionId
     * @param mixed $answerId
     * @return int
     */
    public function saveUserResponses(?int $userId = null, ?int $questionId = null, ?int $answerId = null): int 
    {
        // Validation
        $this->validator->setField("User ID")->setValue($userId)->checkEmpty()->isInteger();
        $this->validator->setField("Question ID")->setValue($questionId)->checkEmpty()->isInteger();
        $this->validator->setField("Answer ID")->setValue($answerId)->checkEmpty()->isInteger();

        // Validate the values, log the error if not
        if (!$this->validator->valid()) {
            error_log(
                "Error in saveUserResponses(): " . $this->validator->getErrors() . "\n", 3, 
                "error.log"
            );

            return 0;
        }

        return (int)$this->testModel->saveQuestionAnswer($userId, $questionId, $answerId);
    }

    /**
     * Returns total question count in the current test.
     *
     * @param mixed $testId
     * @return int
     */
    public function getQuestionCount(?int $testId = null): int 
    {
        // Validation
        $this->validator->setField("Quiz ID")->setValue($testId)->checkEmpty()->isInteger();
        
        // Validate the values, log the error if not
        if (!$this->validator->valid()) {
            error_log(
                "Error in getQuestionCount(): " . $this->validator->getErrors() . "\n", 3, 
                "error.log"
            );

            return 0;
        }

        return (int)$this->testModel->getTestQuestionCount($testId);
    }

    /**
     * Returns correct answer count for the current user.
     *
     * @param mixed $userId
     * @return int
     */
    public function getCorrectAnswerCount(?int $userId = null): int 
    {
        // Validation
        $this->validator->setField("User ID")->setValue($userId)->checkEmpty()->isInteger();
        
        // Validate the values, log the error if not
        if (!$this->validator->valid()) {
            error_log(
                "Error in getCorrectAnswerCount(): " . $this->validator->getErrors() . "\n", 3, 
                "error.log"
            );

            return 0;
        }

        return (int)$this->testModel->getCorrectUserAnswers($userId);
    }
    
    /**
     * saveFinalResult
     * 
     * Saves the final test result to DB
     *
     * @param mixed $userId
     * @param mixed $testId
     * @param mixed $correctAnswerCount
     * @return int
     */
    public function saveFinalResult(?int $userId = null, ?int $testId = null, ?int $correctAnswerCount = null): int
    {
        // Validation
        $this->validator->setField("User ID")->setValue($userId)->checkEmpty()->isInteger();
        $this->validator->setField("Quiz ID")->setValue($testId)->checkEmpty()->isInteger();
        $this->validator->setField("Correct answer count")->setValue($correctAnswerCount)->checkEmpty()->isInteger();

        // Validate the values, log the error if not
        if (!$this->validator->valid()) {
            error_log(
                "Error in saveFinalResult(): " . $this->validator->getErrors() . "\n", 3, 
                "error.log"
            );
            return 0;
        }

        return (int)$this->testModel->saveFinalResult($userId, $testId, $correctAnswerCount);

    }
}
