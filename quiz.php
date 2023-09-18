<?php

require_once './app/Controllers/TestController.php';
session_start();

// Session variables that need to be set for the user to be able to procceed
$sessionVariables = [
    'username',
    'user_test',
    'user_id',
    'current_question'
];

// Check if all session variables are set, redirect back to index if not
foreach ($sessionVariables as $variable) {
    if (!isset($_SESSION[$variable])) {
        header("Location: index.php");
        exit;
    }
}

$tests = new TestController;
$userName = $_SESSION["username"];
$userTest = $_SESSION["user_test"];
$userID = $_SESSION['user_id'];
$currentQuestion = $_SESSION['current_question'];
$totalTestQuestionCount = $tests->getQuestionCount($userTest, $currentQuestion);
$showError = false;

// This happens when procceeding to the next question
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['answer'])) {
        // Save user responses to each question in DB
        $questionID = $_SESSION['question_id'];
        $answerID = $_POST['answer'];
        // Validate answer ID
        $answerID = preg_replace("/[^0-9]/", "", $answerID);

        $result = $tests->saveUserResponses($userID, $questionID, $answerID);

        // Continue to next question after saving data to DB
        if ($result) {
            $currentQuestion++;
            $_SESSION['current_question'] = $currentQuestion;

            // User has responded to all questions, redirect to results page
            if ($currentQuestion > $totalTestQuestionCount) {
                $_SESSION['test_finished'] = 1;
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
$questionData = $tests->getQuestionData($userTest, $currentQuestion);

if (!$questionData) {
    header("Location: index.php");
    exit;
}

$_SESSION["question_id"] = $questionData['question_id'];
$questionTitle = $questionData['question_text'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Question Form</title>
    <link rel="stylesheet" type="text/css" href="./style/style.css">
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
        <input type="submit" value="Turpināt" class="submit-button">
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
