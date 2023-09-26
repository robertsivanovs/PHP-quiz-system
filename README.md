# php-quiz

### Description:

Stack used for creation - LEMP (Linux Nginx MySQL PHP).

Code has been structured to match MVP architecture as close as possible.

PHP 7.4 plain, no frameworks no libraries

### To set up the project:

1. Git clone the repository
2. Import the database [DB is added to the repo -> dbdump.sql]
3. Add DB connection settings [app/classes/database.php]

 ### Notes:

 The database already contains 2 tests each with 5 questions.

### UI/UX:

Select one of the available tests from the dropdown and enter your name:
![Index view](https://i.imgur.com/eMeBIiL.png "Index view")

Select one answer and procceed to the next one:
![Quiz](https://i.imgur.com/8tq2VJn.png "Quiz")

Result shows how many questions out of all were answered correctly:
![Result](https://i.imgur.com/1P4T4ab.png "Result")
