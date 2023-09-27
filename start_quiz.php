<?php

require_once './app/Controllers/UserController.php';
require_once './app/Classes/Validator.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = trim($_POST["username"]);
    $userTest = trim($_POST["test"]);

    // Initialize the validator class and perform validation
    $V1 = new Validator();
    // Validate username
    $V1->setField("Username")->setValue($username)->checkEmpty()->sanitizeUsername();
    // Validate Test ID
    $V1->setField("Test ID")->setValue($userTest)->checkEmpty()->isInteger();

    // If validation was unsuccessfult return to index and display validation errors
    if (!$V1->valid()) {
        error_log("Error when validating user input getTests(): " . $V1->getErrors(), 3, "error.log");
        header("Location: index.php");
        exit;
    }
    
    $user = new UserController();

    // Save user to DB
    $result = $user->processUserData($username);

    if ($result) {
        session_start();

        // Save session variables
        $_SESSION["username"] = $username;
        $_SESSION["user_test"] = $userTest;
        $_SESSION['current_question'] = 1;
        $_SESSION['user_id'] = $result; // Result is user_id or 0

        // Lets start the test
        header("Location: quiz.php");
        exit;
    } else {
        header("Location: index.php");
        exit;
    }
}
?>
