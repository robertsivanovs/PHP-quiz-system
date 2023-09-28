# php-quiz

### Description:

Stack used for creation - LEMP (Linux Nginx MySQL PHP).
Code has been structured to match MVP architecture as close as possible.

PHP 8.2 plain, no frameworks no libraries.

This project is a Test/Quiz system where a user can select one of multiple quizes.
Each quiz test question has multiple answers from which one is the correct one.
At the end of the test the user is shown how many questions have been answered correctly.

All data including user answers are stored in the database (MySQL).

### To set up the project:

1. Git clone the repository
2. Import the database [DB is added to the repo -> php_quiz.sql]
3. Add DB connection settings [app/classes/Database.php]

 ### Notes:

 The database contains 2 tests each with 5 questions.

### UI/UX:

Select one of the available tests from the dropdown and enter your name:
![Index view](https://i.imgur.com/Ie24VIm.png "Index view")

Select one answer and procceed to the next one:
![Quiz](https://i.imgur.com/4IPQfbO.png "Quiz")

Result shows how many questions out of all were answered correctly:
![Result](https://i.imgur.com/W0saIVB.png "Result")
