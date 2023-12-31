<?php

require_once './app/Controllers/TestController.php';
use app\Controllers\TestController;

$tests = new TestController;
$testList = $tests->getTestList();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz system</title>
    <link rel="stylesheet" type="text/css" href="./public/css/styles.css">
</head>
<body class="quiz">
    <h1>Hey! Please input your name and select a test:</h1>
    <br>
    <form action="start_quiz.php" method="POST" class="quiz-form">
        <label for="username">Only letters A-Z (both cases), white space, and characters from ā to Ž are allowed</label>
        <input id="username" type="text" placeholder="John" name="username" required class="input-field" pattern="[A-Za-z ā-Ž]*" title="Only letters A-Z (both cases), white space, and characters from ā to Ž are allowed">

        <label for="test" class="label-field">Quiz selection:</label>
        <select name="test" required class="select-field">
            <?php foreach($testList as $test): ?>
                <option value="<?= $test['id']; ?>"><?= $test['title']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Start" class="submit-button">
    </form>
</body>
</html>
