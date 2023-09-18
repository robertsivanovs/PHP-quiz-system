<?php

declare(strict_types=1);

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
    public function getTests(): array
    {
        try {
            // Set PDO to throw exceptions on errors
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT id, title FROM tests";
            $stmt = $this->con->prepare($sql);
            $result = $stmt->execute();
            $result = $stmt->fetchAll();
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }

        return $result;
    }
    
    /**
     * getTestData
     * 
     * Fetches the current question and its answers from the DB
     *
     * @param  mixed $testID
     * @param  mixed $questionPosition
     * @return array
     */
    public function getQuestionData($testID = null, $questionPosition = null): array {

        $questionData = [];

        if (!$testID || !$questionPosition) {
            return $questionData;
        }
    
        try {
            // Set PDO to throw exceptions on errors
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            // Prepare and execute a query to fetch a single question and its answers for the selected test and position
            $selectedTestId = $testID; // Replace with the actual selected test ID
            $currentQuestionPosition = $questionPosition;
        
            $sql = "SELECT q.id AS question_id, q.question_text, q.`position`, a.id AS answer_id, a.answer_text, a.is_correct
                    FROM questions q
                    JOIN answers a ON q.id = a.question_id
                    WHERE q.test_id = :test_id
                    AND q.`position` = :position";
    
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':test_id', $selectedTestId, PDO::PARAM_INT);
            $stmt->bindParam(':position', $currentQuestionPosition, PDO::PARAM_INT);
            $stmt->execute();
    
            // Fetch the result into an associative array    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (!$questionData) {
                    $questionData = [
                        'question_text' => $row['question_text'],
                        'question_id' => $row['question_id'],
                        'answers' => []
                    ];
                }
                $questionData['answers'][] = [
                    'answer_id' => $row['answer_id'],
                    'answer_text' => $row['answer_text'],
                    'is_correct' => $row['is_correct']
                ];
            }
        
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    
        return $questionData;
    }
    
    /**
     * saveQuestionAnswer
     * 
     * Saves the answer provided the the current question in DB
     *
     * @param  mixed $userID
     * @param  mixed $questionID
     * @param  mixed $answerID
     * @return void
     */
    public function saveQuestionAnswer($userID = null, $questionID = null, $answerID = null) {

        if (!$userID || !$questionID || !$answerID) {
            return 0;
        }

        try {
            // Set PDO to throw exceptions on errors
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO user_responses (user_id, question_id, selected_answer_id) VALUES (:user_id, :question_id, :answer_id)";
            $stmt = $this->con->prepare($sql);
            $stmt->bindValue(':user_id', $userID, PDO::PARAM_INT);
            $stmt->bindValue(':question_id', $questionID, PDO::PARAM_INT);
            $stmt->bindValue(':answer_id', $answerID, PDO::PARAM_INT);
            $result = $stmt->execute();

            if ($result) {
                // Return the ID of the newly created record
                return (int)$this->con->lastInsertId();
            } else {
                return 0; // Failed to insert the user
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public function getTestQuestionCount($testID = null): int {

        if (!$testID) { 
            return 0;
        }

        try {
            // Set PDO to throw exceptions on errors
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT COUNT(*) FROM questions WHERE test_id = :test_id";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':test_id', $testID, PDO::PARAM_INT);
            $result = $stmt->execute();
            
            // Fetch the result and return it
            return $stmt->fetchColumn();

        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }

        return 0;

    }

    public function getCorrectUserAnswers($userID = null) {

        try {
            // Set PDO to throw exceptions on errors
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            $sql = "SELECT COUNT(user_responses.selected_answer_id)
                    FROM user_responses
                    JOIN answers ON user_responses.selected_answer_id = answers.id
                    WHERE user_responses.user_id = :user_id
                    AND answers.is_correct = 1";
    
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch the result and return it
            return $stmt->fetchColumn();

        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }

    }

}
