<?php

require_once './app/Controllers/UserController.php';
require_once './app/Classes/Validator.php';
require_once './app/Classes/SessionManager.php';

use app\Classes\Validator;
use app\Classes\SessionManager;
use app\Controllers\UserController;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = trim($_POST["username"]);
    $userTestId = trim($_POST["test"]);

    // Initialize the validator class and perform validation
    $V1 = new Validator();
    // Validate username
    $V1->setField("Username")->setValue($username)->checkEmpty()->sanitizeUsername();
    // Validate Test ID
    $V1->setField("Test ID")->setValue($userTestId)->checkEmpty()->isInteger();

    // If validation was unsuccessfult return to index and display validation errors
    if (!$V1->valid()) {
        error_log("Error when validating user input getTests(): " . $V1->getErrors() . "\n", 3, "error.log");
        header("Location: index.php");
        exit;
    }
    
    $user = new UserController();

    // Save user to DB
    $result = $user->processUserData($username);

    if ($result) {
        // Start the session and set required data
        $sessionManager = new SessionManager();
        $sessionManager->setSessionVariable([
            "username" => $username,
            "user_test_id" => $userTestId,
            "current_question" => 1,
            "user_id" => $result
        ]);

        // Lets start the test shall we?
        header("Location: quiz.php");
        exit;
    } else {
        header("Location: index.php");
        exit;
    }
}
?>
