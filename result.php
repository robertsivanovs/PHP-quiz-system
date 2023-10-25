<?php

require_once './app/Controllers/TestController.php';
session_start();

// Addiitonal session security
session_regenerate_id(true);

// Session variables that have to be set by this point
$sessionVariables = [
    'username',
    'user_test_id',
    'user_id',
    'current_question',
    'test_finished'
];

// Check if all session variables are set, redirect back to index if not
foreach ($sessionVariables as $variable) {
    if (!isset($_SESSION[$variable])) {
        header("Location: index.php");
        exit;
    }
}

$tests = new TestController;
$currentQuestion = $_SESSION['current_question'];
$userTestId = $_SESSION["user_test_id"];
$username = $_SESSION["username"];
$userID = $_SESSION["user_id"];

// Get total test question count
$totalTestQuestionCount = $tests->getQuestionCount($userTestId, $currentQuestion);

// Get how many answers were correct
$correctQuestionCount = $tests->getCorrectAnswerCount($userID);

// Save final result to DB
$tests->saveFinalResult($userID, $userTestId, $correctQuestionCount);

// Destroy all session data
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Results</title>
    <link rel="stylesheet" type="text/css" href="./public/css/styles.css">
</head>
<body>
    <div class="container">
        <div class="results">
            <h2>Thanks, <?= $username ?>!</h2>
            <p>You have answered correctly <?= $correctQuestionCount; ?> out of <?= $totalTestQuestionCount ?> questions</p>
        </div>
        <a href="./" class="return-link">Back</a>
    </div>
</body>
</html>
