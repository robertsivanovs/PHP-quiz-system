-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 27, 2023 at 11:27 AM
-- Server version: 8.0.34-0ubuntu0.20.04.1
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int NOT NULL,
  `question_id` int NOT NULL,
  `answer_text` varchar(255) DEFAULT NULL,
  `is_correct` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `answer_text`, `is_correct`) VALUES
(1, 1, 'Use echo for faster output to the browser and handling HTML content. It\'s the preferred choice in most cases.', 1),
(2, 1, 'print is faster than echo for outputting content in PHP scripts.', 0),
(3, 1, 'Both echo and print can return values, so they are interchangeable.', 0),
(4, 1, 'echo should be used when you want to capture the return value for conditional checks.', 0),
(5, 2, 'A PHP session is a server-side mechanism to maintain user data across multiple web pages during a visit, using a unique session ID.', 1),
(6, 2, 'A PHP session stores data in the user\'s browser using cookies, mainly for small data storage.', 0),
(9, 3, 'PHP\'s \"super global\" variables are used for creating local variables within functions and should not be used for any specific purpose.', 0),
(10, 3, 'PHP\'s \"super global\" variables are predefined variables that are accessible from any part of a PHP script.', 1),
(11, 3, 'PHP\'s \"super global\" variables are used for global data storage across different PHP scripts on the server, allowing sharing of data between users.', 0),
(12, 4, 'To prevent SQL injection in PHP, you should always use the mysql_real_escape_string() function on user input before inserting it into your database queries.', 0),
(13, 4, 'To prevent SQL injection in PHP, you should use prepared statements and parameterized queries when interacting with databases. This way, user input is automatically sanitized and separated from the SQL query, reducing the risk of SQL injection attacks.', 1),
(22, 5, 'The include statement is used to import classes and functions from external PHP files, while require is used for including CSS files in a web page.', 0),
(23, 5, 'The only difference is that include is used for optional files, while require is for essential files.', 0),
(24, 5, 'PHP\'s include statement is used to include and run external PHP files within a script, and it does not stop the script if the file is not found.', 1),
(25, 5, 'include and require are used for creating and displaying pop-up windows in PHP applications, with include used for pop-ups that can be closed, and require for pop-ups that are non-closable.', 0),
(26, 6, 'The localStorage object enables you to access the user\'s location data in a web application.', 0),
(27, 6, 'localStorage is used to retrieve and display user\'s emails from their inbox.', 0),
(28, 6, 'The localStorage object allows you to store key-value pairs in a web browser, providing a way to persistently store data on the client-side.', 1),
(29, 6, 'localStorage is used to send HTTP requests to a server to retrieve external data for a web page', 0),
(30, 7, 'The setTimeout function in JavaScript is used to create a countdown timer on a webpage.', 0),
(31, 7, 'setTimeout is primarily used to delay the execution of code until the browser finishes loading the webpage', 0),
(32, 7, 'The purpose of the setTimeout function in JavaScript is to schedule the execution of a specific function or code block after a specified delay.', 1),
(33, 8, 'In JavaScript, you can declare a constant variable by using the var keyword instead of let or const.', 0),
(34, 8, 'To declare a variable as constant (immutable) in JavaScript, you use the const keyword followed by the variable name, like this: const myConstant = 42;.', 1),
(35, 9, 'The map() function in JavaScript is primarily used for creating geographical maps and rendering geographic data on web pages.', 0),
(36, 9, 'The purpose of the map() function in JavaScript is to create a new array by applying a provided function to each element of an existing array, allowing you to transform or manipulate the data in the original array.', 1),
(40, 10, 'In JavaScript, the primary use of the NaN value is to represent \"Not a Negative\" numbers.', 0),
(41, 10, 'NaN is used to indicate that a number is extremely large and cannot be represented in regular numerical formats in JavaScript.', 0),
(42, 10, 'The primary use of the NaN (Not-a-Number) value in JavaScript is to represent the result of an operation that should return a valid number but doesn\'t.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int NOT NULL,
  `test_id` int DEFAULT NULL,
  `question_text` varchar(255) DEFAULT NULL,
  `position` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `test_id`, `question_text`, `position`) VALUES
(1, 1, 'What is the difference between echo and print statements in PHP, and when would you use one over the other?', 1),
(2, 1, 'Explain what a PHP session is and how it can be used to maintain user state across multiple web pages.', 2),
(3, 1, 'What is the purpose of PHP\'s \"super global\" variables, and can you name a few of them?', 3),
(4, 1, 'How do you prevent SQL injection in PHP when working with databases?', 4),
(5, 1, 'What does PHP\'s include statement do, and how does it differ from require?', 5),
(6, 2, 'What does the localStorage object in JavaScript allow you to do?', 1),
(7, 2, 'What is the purpose of the setTimeout function in JavaScript?', 2),
(8, 2, 'How do you declare a variable as constant (immutable) in JavaScript?', 3),
(9, 2, 'What is the purpose of the map() function in JavaScript?', 4),
(10, 2, 'What is the primary use of the NaN value in JavaScript?', 5);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `test_id` int NOT NULL,
  `correct_answers` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `user_id`, `test_id`, `correct_answers`) VALUES
(1, 84, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `title`) VALUES
(1, 'PHP Quiz'),
(2, 'JavaScript Quiz');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_responses`
--

CREATE TABLE `user_responses` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `question_id` int DEFAULT NULL,
  `selected_answer_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_responses`
--
ALTER TABLE `user_responses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `user_responses`
--
ALTER TABLE `user_responses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
