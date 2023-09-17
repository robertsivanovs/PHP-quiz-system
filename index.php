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
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Sveiki! Lūdzu, ievadiet savu vārdu:</h1>
    <br>
    <form action="start_quiz.php" method="POST">
        <input type="text" name="username" required>
        <br>
        <label for="test">Izvēlieties testu:</label>
        <br>
        <select name="test" required>
            <?php foreach($testList as $test): ?>
                <option value="<?= $test['id']; ?>"><?= $test['title']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Sākt testu">
    </form>
</body>
</html>
