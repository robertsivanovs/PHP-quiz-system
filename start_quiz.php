<?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

require_once './app/Controllers/UserController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $userTest = $_POST["test"];

    // Instantiate the class
    $user = new UserController();

    // Call the specific method to handle the form submission
    $result = $user->processUserData($username);

    // Redirect or display a success message based on the result
    if ($result) {
        session_start();

        // Save session variables
        $_SESSION["username"] = $username;
        $_SESSION["user_test"] = $userTest;
        $_SESSION['current_question'] = 1;
        $_SESSION['user_id'] = $result; // Result is user_id or 0

        header("Location: quiz.php");
        exit;
    } else {
        // Handle errors or display an error message
        // You can redirect to an error page or display a message here
    }
}
?>