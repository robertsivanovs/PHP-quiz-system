<?php

require_once './app/Controllers/TestController.php';
require_once './app/Classes/SessionManager.php';

use app\Classes\SessionManager;
use app\Controllers\TestController;

// Start the session and set required data
$sessionManager = new SessionManager();

// Check if all session variables are set, redirect back to index if not
if (!$sessionManager->checkSessionVariables() || !$sessionManager->getSessionVariable("test_finished")) {
    header("Location: index.php");
    exit;
}

$tests = new TestController;

$currentQuestion = $sessionManager->getSessionVariable("current_question");
$userTestId = $sessionManager->getSessionVariable("user_test_id");
$username = $sessionManager->getSessionVariable("username");
$userID = $sessionManager->getSessionVariable("user_id");

// Get total test question count
$totalTestQuestionCount = $tests->getQuestionCount($userTestId, $currentQuestion);

// Get how many answers were correct
$correctQuestionCount = $tests->getCorrectAnswerCount($userID);

// Save final result to DB
$tests->saveFinalResult($userID, $userTestId, $correctQuestionCount);

// Destroy all session data
$sessionManager->destroySession();
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
