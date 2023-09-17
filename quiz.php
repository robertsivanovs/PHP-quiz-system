<?php

require_once './app/Controllers/TestController.php';

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

session_start();

// Session variable that need to be set for the user to be able to procceed
$sessionVariables = [
    'username',
    'user_test',
    'user_id',
    'current_question'
];

// Check if all session variables are set
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

// This happens when procceeding to the next question
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $questionID = $_SESSION['question_id'];
    $answerID = $_POST['answer'];
    $result = $tests->saveUserResponses($userID, $questionID, $answerID);

    if ($result) {
        $currentQuestion++;
        $_SESSION['current_question'] = $currentQuestion;
    }

}

$questionData = $tests->getTestData($userTest, $currentQuestion);

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
</head>
<body>
    <h3> <?= $questionTitle; ?> </h3>
    <form action="quiz.php" method="post">
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
        <input type="submit" value="Submit">
    </form>
</body>
</html>