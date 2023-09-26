<?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

require_once './app/Controllers/TestController.php';

$tests = new TestController;
$testList = $tests->getTestList();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Testa sistēma</title>
    <link rel="stylesheet" type="text/css" href="./style/style.css">
</head>
<body>
    <h1>Sveiki! Lūdzu, ievadiet savu vārdu:</h1>
    <br>
    <form action="start_quiz.php" method="POST" class="index-form">
        <input type="text" name="username" required class="input-field">
        <label for="test" class="label-field">Izvēlieties testu:</label>
        <select name="test" required class="select-field">
            <?php foreach($testList as $test): ?>
                <option value="<?= $test['id']; ?>"><?= $test['title']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Sākt testu" class="submit-button">
    </form>
</body>
</html>
