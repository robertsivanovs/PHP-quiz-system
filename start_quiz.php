<?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

require_once './app/Controllers/UserController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];

    // Instantiate the class
    $user = new UserController();

    // Call the specific method to handle the form submission
    $result = $user->processUserData($username);

    // Redirect or display a success message based on the result
    if ($result) {
        header("Location: success.php");
        exit;
    } else {
        // Handle errors or display an error message
        // You can redirect to an error page or display a message here
    }
}
?>