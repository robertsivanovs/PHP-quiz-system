<?php

declare(strict_types=1);
require_once './app/Models/Test.php';

class TestController {
    private $testModel;

    public function __construct() {
        $this->testModel = new Test();
    }

    /**
     * Fetches the list of all tests from the DB.
     *
     * @return array
     */
    public function getTestList(): array {
        return $this->testModel->getTests();
    }

    /**
     * Fetches current question and its answers from DB.
     *
     * @param int $userTest
     * @param int $questionPosition
     * @return array
     */
    public function getQuestionData(int $userTest, int $questionPosition): array {
        
        if (!$userTest || !$questionPosition) {
            return [];
        }

        return $this->testModel->getQuestionData($userTest, $questionPosition) ?: [];
    }

    /**
     * Saves user provided answers to DB.
     *
     * @param int $userID
     * @param int $questionID
     * @param int $answerID
     * @return int
     */
    public function saveUserResponses(int $userID, int $questionID, int $answerID): int {

        if (!$userID || !$questionID || !$answerID) {
            return 0;
        }

        return (int)$this->testModel->saveQuestionAnswer($userID, $questionID, $answerID);
    }

    /**
     * Returns total question count in the current test.
     *
     * @param int $testID
     * @return int
     */
    public function getQuestionCount(int $testID): int {

        if (!$testID) {
            return 0;
        }

        return (int)$this->testModel->getTestQuestionCount($testID);
    }

    /**
     * Returns correct answer count for the current user.
     *
     * @param int $userID
     * @return int
     */
    public function getCorrectAnswerCount(int $userID): int {

        if (!$userID) {
            return 0;
        }

        return (int)$this->testModel->getCorrectUserAnswers($userID);
    }
}
