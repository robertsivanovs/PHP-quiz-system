<?php

require_once './app/Controllers/TestController.php';
require_once './app/Classes/Validator.php';
require_once './app/Classes/SessionManager.php';

use app\Classes\Validator;
use app\Classes\SessionManager;
use app\Controllers\TestController;

// Start the session and set required data
$sessionManager = new SessionManager();

// Check if all session variables are set, redirect back to index if not
if (!$sessionManager->checkSessionVariables()) {
    header("Location: index.php");
    exit;
}

$tests = new TestController;

// Fetch session variables
$userName = $sessionManager->getSessionVariable("username");
$userTestId = (int)$sessionManager->getSessionVariable("user_test_id");
$userID = (int)$sessionManager->getSessionVariable("user_id");
$currentQuestion = (int)$sessionManager->getSessionVariable("current_question");

// Fetch total question count within the current quiz
$totalTestQuestionCount = $tests->getQuestionCount($userTestId, $currentQuestion);
$showError = false;

// This happens when procceeding to the next question
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['answer'])) {
        // Save user responses to each question in DB
        $questionID = $sessionManager->getSessionVariable("question_id");
        $answerID = $_POST['answer'];
        // Initialize the validator class and perform validation
        $V1 = new Validator();
        // Validate Test ID
        $V1->setField("Answer ID")->setValue($answerID)->checkEmpty()->isInteger();

        // If validation was unsuccessfult return to index and display validation errors
        if (!$V1->valid()) {
            error_log("Error when validating user answer input: " . $V1->getErrors(), 3, "error.log");
            header("Location: index.php");
            exit;
        }

        // Save user response to each question in DB
        $result = $tests->saveUserResponses($userID, $questionID, $answerID);

        // Continue to next question after saving data to DB
        if ($result) {
            $currentQuestion++;
            $sessionManager->setSessionVariable(["current_question" => $currentQuestion]);

            // User has responded to all questions, redirect to results page
            if ($currentQuestion > $totalTestQuestionCount) {
                $sessionManager->setSessionVariable(["test_finished" => 1]);
                header("Location: result.php");
                exit;
            }

            // Prevent continuing to the next question by refreshing the page
            header("Location: quiz.php");
            exit;
        }
    } else {
        $showError = true;
    }
}

// Fetch current question data from DB
$questionData = $tests->getQuestionData($userTestId, $currentQuestion);

// If no question data found redirect to index
if (!$questionData) {
    header("Location: index.php");
    exit;
}

// Store question ID data in session variable
$sessionManager->setSessionVariable(["question_id" => $questionData['question_id']]);

// Set Question title
$questionTitle = $questionData['question_text'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Question Form</title>
    <link rel="stylesheet" type="text/css" href="./public/css/styles.css">
</head>
<body>
    <?php if ($showError): ?>
        <span class="error">No answer provided!</span>
    <?php endif; ?>
    <h3 class="question-title"><?= $questionTitle; ?></h3>
    <form action="quiz.php" method="post" class="quiz-form">
        <?php
        // Iterate through the answers and create radio buttons
        foreach ($questionData as $question) {
            if (is_array($question)) {
                foreach ($question as $answerData) {
                    echo '<p>';
                    echo '<input type="radio" name="answer" value="' . $answerData['answer_id'] . '"';
                    echo '> ' . $answerData['answer_text'] . '<br>';
                    echo '</p>';
                }
            }
        }
        ?>
        <input type="submit" value="Continue" class="submit-button">
    </form>
    <!-- Progress bar -->
    <div class="progress-container">
        <div class="progress-bar" id="myProgressBar"><?= ($currentQuestion - 1) / $totalTestQuestionCount * 100 ?>%</div>
    </div>
    <script>

    var progressBar = document.getElementById("myProgressBar");
    // Set the new width (for example, 50%)
    var newWidth = <?= ($currentQuestion - 1) / $totalTestQuestionCount * 100 ?>;
    // Change the width using the style property
    progressBar.style.width = newWidth + "%";
    </script>

</body>
</html>
