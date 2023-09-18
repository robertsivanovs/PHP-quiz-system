<?php

require_once './app/Controllers/TestController.php';

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

session_start();

// Session variables that have to be set by this point
$sessionVariables = [
    'username',
    'user_test',
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
$userTest = $_SESSION["user_test"];
$username = $_SESSION["username"];
$userID = $_SESSION["user_id"];

$totalTestQuestionCount = $tests->getQuestionCount($userTest, $currentQuestion);
$correctQuestionCount = $tests->getCorrectAnswerCount($userID);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Results</title>
</head>
<body>
    <div class="container">
        <div class="results">
            <h2>Paldies, <?= $username ?></h2>
            <p>Esat pareizi atbildējis uz <?= $correctQuestionCount; ?> no <?= $totalTestQuestionCount ?> jautājumiem</p>
        </div>
    </div>
</body>
</html>