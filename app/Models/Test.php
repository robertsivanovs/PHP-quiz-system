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
        parent::__construct();
        // Set PDO to throw exceptions on errors        
        $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    /**
     * getTests
     *
     * @return array
     */
    public function getTests(): array
    {
        try {
            $sql = "SELECT id, title FROM tests";
            $stmt = $this->con->prepare($sql);
            $result = $stmt->execute();
            $result = $stmt->fetchAll();

            return $result;

        } catch (PDOException $e) {
            // Log the error
            error_log("Error in getTests(): " . $e->getMessage(), 3, "error.log");
            return [];
        }

        return [];
    }
    
    /**
     * getTestData
     * 
     * Fetches the current question and its answers from the DB
     *
     * @param int $testID
     * @param int $questionPosition
     * @return array
     */
    public function getQuestionData(int $testID, int $questionPosition): array 
    {
        $questionData = [];

        try {
            $sql = "SELECT q.id AS question_id, q.question_text, q.`position`, a.id AS answer_id, a.answer_text, a.is_correct
                    FROM questions q
                    JOIN answers a ON q.id = a.question_id
                    WHERE q.test_id = :test_id
                    AND q.`position` = :position";

            $stmt = $this->con->prepare($sql);
            $stmt->execute([
                ':test_id' => $testID,
                ':position' => $questionPosition,
            ]);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (empty($questionData)) {
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
            error_log("Error in getQuestionData(): " . $e->getMessage(), 3, "error.log");
            return [];
        }
    
        return $questionData;
    }
    
    /**
     * saveQuestionAnswer
     * 
     * Saves the answer provided the the current question in DB
     *
     * @param int $userID
     * @param int $questionID
     * @param int $answerID
     * @return int
     */
    public function saveQuestionAnswer(int $userID, int $questionID, int $answerID): int 
    {
        try {
            $sql = "INSERT INTO user_responses (user_id, question_id, selected_answer_id) VALUES (:user_id, :question_id, :answer_id)";
            $stmt = $this->con->prepare($sql);
            $result = $stmt->execute([
                ':user_id' => $userID,
                ':question_id' => $questionID,
                ':answer_id' => $answerID
            ]);

            if ($result) {
                // Return the ID of the newly created record
                return (int)$this->con->lastInsertId();
            } else {
                return 0; // Failed to insert the user
            }
        } catch (PDOException $e) {
            // Log the error
            error_log("Error in saveQuestionAnswer(): " . $e->getMessage(), 3, "error.log");
            return 0;
        }

    }
    
    /**
     * getTestQuestionCount
     *
     * @param int $testID
     * @return int
     */
    public function getTestQuestionCount(int $testID): int 
    {
        try {
            $sql = "SELECT COUNT(*) FROM questions WHERE test_id = :test_id";
            $stmt = $this->con->prepare($sql);
            $stmt->execute([':test_id' => $testID]);

            // Fetch the result and return it
            return $stmt->fetchColumn();

        } catch (PDOException $e) {
            // Log the error
            error_log("Error in getTestQuestionCount(): " . $e->getMessage(), 3, "error.log");
            return 0;
        }

        return 0;

    }
    
    /**
     * getCorrectUserAnswers
     * 
     * Get the count of correct answers provided by the user
     *
     * @param int $userID
     * @return int
     */
    public function getCorrectUserAnswers(int $userID): int 
    {
        try {   
            $sql = "SELECT COUNT(user_responses.selected_answer_id)
                    FROM user_responses
                    JOIN answers ON user_responses.selected_answer_id = answers.id
                    WHERE user_responses.user_id = :user_id
                    AND answers.is_correct = 1";
    
            $stmt = $this->con->prepare($sql);
            $stmt->execute([':user_id' => $userID]);

            // Fetch the result and return it
            return (int)$stmt->fetchColumn();

        } catch (PDOException $e) {
            // Log the error
            error_log("Error in getCorrectUserAnswers(): " . $e->getMessage(), 3, "error.log");
            return 0;
        }
    }
}
