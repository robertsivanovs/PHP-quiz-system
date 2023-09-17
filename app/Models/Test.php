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
     * @param  mixed $testID
     * @param  mixed $questionPosition
     * @return void
     */
    public function getTestData($testID = null, $questionPosition = null) {

        if (!$testID || !$questionPosition) {
            return null;
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
            $questionData = null;
    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (!$questionData) {
                    $questionData = [
                        'question_text' => $row['question_text'],
                        'answers' => []
                    ];
                }
                $questionData['answers'][] = [
                    'answer_id' => $row['answer_id'],
                    'answer_text' => $row['answer_text'],
                    'is_correct' => $row['is_correct']
                ];
            }
    
            return $questionData;
    
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    
        return null;
    }

}
