-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2026 at 08:06 PM
-- Server version: 8.0.44
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(6, 'PHP'),
(7, 'Python'),
(8, 'Java'),
(9, 'Rust'),
(10, 'C'),
(11, 'C++'),
(12, 'JavaScript'),
(13, 'Go'),
(14, 'Swift'),
(15, 'TypeScript');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_0` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct_answer` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `category_id`, `question_text`, `answer_0`, `answer_1`, `answer_2`, `correct_answer`) VALUES
(1, 6, 'Кой символ се използва за обозначаване на променлива в PHP?', '$', '@', '#', 0),
(2, 6, 'Кой от следните типове не съществува в PHP?', 'integer', 'char', 'array', 1),
(3, 6, 'С коя функция се извежда текст в PHP?', 'echo', 'print', 'display', 0),
(4, 6, 'Какъв е резултатът от strlen(\"PHP\")?', '2', '3', '4', 1),
(5, 6, 'Как се дефинира константа в PHP?', 'define()', 'const', 'set()', 0),
(6, 6, 'Коя е правилната разширение на PHP файл?', '.ph', '.php', '.phtml', 1),
(7, 6, 'Кой супер глобален масив съдържа данните от формата с POST метод?', '$_GET', '$_POST', '$_FORM', 1),
(8, 6, 'Коя функция се използва за включване на файл?', 'require()', 'attach()', 'import()', 0),
(9, 6, 'Как се проверява дали дадена променлива съществува?', 'isset()', 'exist()', 'check()', 0),
(10, 6, 'Кой оператор се използва за конкатенация на низове?', '+', '.', '&', 1),
(11, 7, 'Коя функция извежда текст в Python?', 'print()', 'echo()', 'display()', 0),
(12, 7, 'Как се декларира променлива в Python?', 'var x = 5', 'x = 5', 'let x = 5', 1),
(13, 7, 'Кой тип данни представя списък?', '[]', '{}', '()', 0),
(14, 7, 'Как се извиква дължината на списък?', 'len()', 'size()', 'count()', 0),
(15, 7, 'Как се коментира един ред код?', '//', '#', '--', 1),
(16, 7, 'Кой метод добавя елемент в списък?', 'append()', 'push()', 'add()', 0),
(17, 7, 'Коя команда спира изпълнението на цикъл?', 'break', 'exit', 'stop', 0),
(18, 7, 'Как се дефинира функция?', 'def myFunc():', 'function myFunc():', 'func myFunc():', 0),
(19, 7, 'Как се импортира модул?', 'import', 'include', 'require', 0),
(20, 7, 'Как се преобразува число в текст?', 'str()', 'int()', 'toString()', 0),
(21, 8, 'Какво е JVM?', 'Java Virtual Machine', 'Java Visual Model', 'Java Vector Method', 0),
(22, 8, 'Коя дума дефинира клас?', 'class', 'def', 'struct', 0),
(23, 8, 'Коя е основната функция в Java програмата?', 'run()', 'start()', 'main()', 2),
(24, 8, 'Кой модификатор прави член достъпен само в същия клас?', 'private', 'public', 'protected', 0),
(25, 8, 'Кой оператор се използва за сравнение?', '=', '==', '===', 1),
(26, 8, 'Как се създава обект?', 'new', 'create', 'make', 0),
(27, 8, 'Кой тип променлива съдържа цели числа?', 'int', 'float', 'char', 0),
(28, 8, 'Коя библиотека се използва за вход/изход?', 'java.io', 'java.util', 'java.net', 0),
(29, 8, 'Как се дефинира масив?', 'int[] arr;', 'int arr[];', 'и двете', 2),
(30, 8, 'Какво е наследяване?', 'Повторение на код', 'Използване на клас от друг клас', 'Свързване на пакети', 1),
(31, 9, 'Как се дефинира променлива в Rust?', 'let', 'var', 'def', 0),
(32, 9, 'Коя ключова дума прави променлива променяема?', 'mut', 'var', 'dyn', 0),
(33, 9, 'Как се дефинира функция?', 'fn', 'func', 'def', 0),
(34, 9, 'Какво означава “ownership”?', 'Контрол на паметта', 'Име на модул', 'Тип на данни', 0),
(35, 9, 'Какво връща println!()?', 'Стойност', 'Нищо', 'Булев тип', 1),
(36, 9, 'Как се дефинира структура?', 'struct', 'class', 'object', 0),
(37, 9, 'Коя макрос функция отпечатва на екрана?', 'println!()', 'echo()', 'display()', 0),
(38, 9, 'Какво означава “borrow”?', 'Временно използване на референция', 'Дублиране на обект', 'Създаване на собственик', 0),
(39, 9, 'Как се дефинира масив?', '[1, 2, 3]', '{1, 2, 3}', '(1, 2, 3)', 0),
(40, 9, 'Как се компилира програма в Rust?', 'rustc file.rs', 'gcc file.rs', 'cargo file.rs', 0),
(41, 10, 'Кой е основният входен метод в C?', 'scanf()', 'input()', 'read()', 0),
(42, 10, 'Как се извежда текст?', 'printf()', 'echo()', 'print()', 0),
(43, 10, 'Какво означава “#include”?', 'Включва библиотека', 'Декларира променлива', 'Задава константа', 0),
(44, 10, 'Коя е основната функция?', 'main()', 'start()', 'run()', 0),
(45, 10, 'Кой символ завършва всеки ред?', '.', ';', ':', 1),
(46, 10, 'Какво връща main() при успех?', '0', '1', '-1', 0),
(47, 10, 'Кой тип съхранява символи?', 'char', 'string', 'text', 0),
(48, 10, 'Как се декларира масив?', 'int arr[10];', 'arr<int>[10];', 'int[10] arr;', 0),
(49, 10, 'Кой оператор е за сравнение?', '==', '=', '!=', 0),
(50, 10, 'Как се компилира програма на C?', 'gcc file.c', 'javac file.c', 'python file.c', 0),
(51, 11, 'Как се извежда текст на екрана?', 'cout <<', 'printf()', 'print()', 0),
(52, 11, 'Коя библиотека съдържа cout?', '<iostream>', '<stdio.h>', '<string>', 0),
(53, 11, 'Как се дефинира клас?', 'class', 'struct', 'object', 0),
(54, 11, 'Кой е операторът за достъп до член?', '.', '->', ':', 0),
(55, 11, 'Коя е основната функция?', 'main()', 'start()', 'run()', 0),
(56, 11, 'Кой оператор се използва за нов обект?', 'new', 'malloc', 'create', 0),
(57, 11, 'Какво е наследяване?', 'Използване на друг клас', 'Повторно деклариране', 'Изтриване на клас', 0),
(58, 11, 'Кой е операторът за сравнение?', '==', '=', '!=', 0),
(59, 11, 'Кой тип съхранява текстови низове?', 'string', 'char', 'text', 0),
(60, 11, 'Кой компилатор често се използва?', 'g++', 'javac', 'rustc', 0),
(61, 12, 'Коя ключова дума декларира променлива?', 'var', 'int', 'declare', 0),
(62, 12, 'Как се извежда текст в конзолата?', 'console.log()', 'print()', 'echo()', 0),
(63, 12, 'Какъв тип е NaN?', 'number', 'undefined', 'string', 0),
(64, 12, 'Как се сравнява строго?', '==', '===', '=', 1),
(65, 12, 'Как се създава функция?', 'function myFunc()', 'def myFunc()', 'func myFunc()', 0),
(66, 12, 'Кой тип е масивът?', 'object', 'array', 'list', 0),
(67, 12, 'Как се създава обект?', '{}', '[]', '()', 0),
(68, 12, 'Какво връща typeof null?', '\"object\"', '\"null\"', '\"undefined\"', 0),
(69, 12, 'Как се добавя елемент в масив?', 'push()', 'add()', 'insert()', 0),
(70, 12, 'Как се извиква alert?', 'alert()', 'message()', 'popup()', 0),
(71, 13, 'Как се дефинира променлива в Go?', 'var', 'let', 'set', 0),
(72, 13, 'Как се дефинира функция?', 'func', 'function', 'def', 0),
(73, 13, 'Как се отпечатва на екрана?', 'fmt.Println()', 'print()', 'echo()', 0),
(74, 13, 'Как се дефинира пакет?', 'package main', 'import main', 'module main', 0),
(75, 13, 'Как се компилира програма?', 'go run file.go', 'gcc file.go', 'rustc file.go', 0),
(76, 13, 'Коя е основната функция?', 'main()', 'start()', 'init()', 0),
(77, 13, 'Как се създава масив?', 'var arr [5]int', 'arr := [5]int', 'int arr[5]', 0),
(78, 13, 'Какво е slice?', 'Динамичен масив', 'Функция', 'Тип int', 0),
(79, 13, 'Как се импортира пакет?', 'import', 'include', 'require', 0),
(80, 13, 'Как се дефинира структура?', 'type Struct struct {}', 'struct {}', 'class {}', 0),
(81, 14, 'Как се дефинира променлива?', 'var', 'let', 'define', 0),
(82, 14, 'Коя ключова дума прави променлива константа?', 'let', 'const', 'fixed', 0),
(83, 14, 'Как се отпечатва на екрана?', 'print()', 'echo()', 'write()', 0),
(84, 14, 'Как се дефинира функция?', 'func', 'def', 'function', 0),
(85, 14, 'Как се дефинира клас?', 'class', 'struct', 'object', 0),
(86, 14, 'Как се създава масив?', '[ ]', '{ }', '( )', 0),
(87, 14, 'Как се добавя елемент към масив?', 'append()', 'push()', 'add()', 0),
(88, 14, 'Какво означава \"optional\"?', 'Променлива, която може да е nil', 'Променлива с фиксиран тип', 'Променлива за цикли', 0),
(89, 14, 'Как се проверява стойност на optional?', 'if let', 'if optional', 'unwrap()', 0),
(90, 14, 'Коя среда е типична за Swift?', 'Xcode', 'IntelliJ', 'VSCode', 0),
(91, 15, 'Какво добавя TypeScript към JavaScript?', 'Типизация', 'По-бързо изпълнение', 'Графичен интерфейс', 0),
(92, 15, 'Как се декларира променлива с тип?', 'let x: number = 5', 'x = 5', 'var x = number', 0),
(93, 15, 'Как се дефинира интерфейс?', 'interface', 'struct', 'class', 0),
(94, 15, 'Коя команда компилира TypeScript?', 'tsc', 'node', 'npm', 0),
(95, 15, 'Какъв файл се получава след компилация?', '.ts', '.js', '.tsx', 1),
(96, 15, 'Как се дефинира функция с тип връщане?', 'function test(): string', 'func test(): string', 'def test(): string', 0),
(97, 15, 'Как се описва масив от числа?', 'number[]', 'int[]', 'array<number>', 0),
(98, 15, 'Коя ключова дума прави свойство само за четене?', 'readonly', 'const', 'static', 0),
(99, 15, 'Как се импортира модул?', 'import', 'require', 'include', 0),
(100, 15, 'Коя команда стартира проект TypeScript?', 'npm start', 'tsc start', 'run ts', 0),
(103, 6, 'Какъв ще бъде резултатът след изпълнението на следния PHP код:\r\n```\r\n$data = [\'apple\', \'banana\', \'cherry\'];\r\nfunction toUpper(&$item, $key) {\r\n    item=strtoupper(item = strtoupper(\r\nitem=strtoupper(item);\r\n}\r\narray_walk($data, \'toUpper\');\r\nprint_r($data);```', 'asfaf', 'ye', 'feoiaf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  `score` int NOT NULL,
  `total` int NOT NULL,
  `duration` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `user_id`, `category_id`, `score`, `total`, `duration`, `created_at`) VALUES
(1, 51, 6, 11, 11, 47, '2025-12-22 10:06:22');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  `score` int NOT NULL,
  `total` int NOT NULL,
  `quiz_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `duration` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `user_id`, `category_id`, `score`, `total`, `quiz_date`, `duration`) VALUES
(84, 47, 7, 10, 10, '2025-11-05 05:30:15', 43),
(85, 47, 6, 8, 10, '2025-11-05 05:31:21', 46),
(86, 47, 11, 9, 10, '2025-11-05 05:32:56', 69),
(87, 47, 12, 7, 10, '2025-11-05 05:34:34', 69),
(88, 47, 13, 7, 10, '2025-11-05 05:36:05', 69);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_number` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `verification_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_expires` datetime DEFAULT NULL,
  `reset_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `course_number`, `password_hash`, `is_verified`, `verification_token`, `verification_expires`, `reset_token`, `reset_expires`, `is_admin`) VALUES
(47, '22324@uktc-bg.com', '22324', '$2y$10$bI4z3JN4EJfd.oIUic9oqu.Rs8HYlethl.YrJXPXwCAR2oeuXio56', 1, NULL, NULL, NULL, NULL, 0),
(51, 'admin@example.com', '99999', '$2y$10$G7OHndyoRCDxVf4GAm6REO.mglID7I01faK.vCZa2hCr.VOE5IjYG', 1, NULL, NULL, NULL, NULL, 1),
(55, '22401@uktc-bg.com', '22401', '$2y$10$LQBn2EbO565Aj6jNYBhogeNy5KIyxtD49owIKcMNlEAPcTrcsNZ5K', 1, NULL, NULL, NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `course_number` (`course_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
