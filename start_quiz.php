<?php
require_once './app/Controllers/UserController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $userTest = $_POST["test"];

    // Only way this can occur is by tinkering with form HTML manually
    if (!$username || !$userTest) {
        header("Location: index.php");
        exit;
    }

    $username = trim($username);
    $userTest = trim($userTest);

    // Remove all symbols except alphanumeric characters and whitespace
    $username = preg_replace("/[^a-zA-Z0-9\s]/", "", $username);

    // Remove all symbols except numeric characters
    $userTest = preg_replace("/[^0-9]/", "", $userTest);

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
