-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 22 2021 г., 18:13
-- Версия сервера: 8.0.23
-- Версия PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `todolist`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date_to` date NOT NULL,
  `date_from` date NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `priority` enum('high','medium','low') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` enum('to do','in progress','done','canceled') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'to do',
  `creator_user` int NOT NULL,
  `responsible_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `date_to`, `date_from`, `update_date`, `priority`, `status`, `creator_user`, `responsible_user`) VALUES
(1, 'Разработать пользовательскую корзину', 'Есть много вариантов Lorem Ipsum, но большинство из них имеет не всегда приемлемые модификации, например, юмористические вставки или слова, которые даже отдалённо не напоминают латынь.', '2021-05-31', '2021-05-22', '2021-05-22 17:08:10', 'high', 'to do', 10, 12),
(2, 'Установить роутер в офисе', 'Многие думают, что Lorem Ipsum - взятый с потолка псевдо-латинский набор слов, но это не совсем так. Его корни уходят в один фрагмент классической латыни 45 года н.э., то есть более двух тысячелетий назад. ', '2021-05-26', '2021-05-01', '2021-05-22 17:07:53', 'medium', 'in progress', 10, 12),
(3, 'Разослать почту клиентам', 'Если вы регулярно пользуетесь этим сайтом и хотите быть уверенным в его дальнейшем постоянном функционировании, подумайте о небольшом пожертвовании, которое помогло бы оплатить его хостинг и трафик.', '2021-06-24', '2021-05-12', '2021-05-22 16:13:23', 'medium', 'to do', 10, 12),
(4, 'Еще одно задание', 'Есть много вариантов Lorem Ipsum, но большинство из них имеет не всегда приемлемые модификации, например, юмористические вставки или слова, которые даже отдалённо не напоминают латынь.', '2021-05-22', '2021-05-01', '2021-05-22 16:18:55', 'high', 'to do', 10, 12),
(5, 'Задание #1', 'Его популяризации в новое время послужили публикация листов Letraset с образцами Lorem Ipsum в 60-х годах и, в более недавнее время, программы электронной вёрстки типа Aldus PageMaker, в шаблонах которых используется Lorem Ipsum.', '2021-07-01', '2021-04-01', '2021-05-22 17:08:14', 'medium', 'done', 10, 12),
(6, 'Еще одно задание #2', 'Lorem Ipsum - это текст-\"рыба\", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной \"рыбой\" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов.', '2021-05-19', '2021-05-07', '2021-05-22 16:29:31', 'high', 'to do', 10, 12),
(7, 'Сделать что то интересное', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона, а также реальное распределение букв и пробелов в абзацах', '2021-05-20', '2021-05-03', '2021-05-22 16:30:15', 'high', 'to do', 10, 12),
(8, 'Супер пупер задание', 'Здесь ваш текст..\" Многие программы электронной вёрстки и редакторы HTML используют Lorem Ipsum в качестве текста по умолчанию, ', '2021-05-22', '2021-05-06', '2021-05-22 17:08:02', 'high', 'to do', 10, 12),
(9, 'Задание для Сидора', 'Есть много вариантов!!!', '2021-05-26', '2021-05-01', '2021-05-22 17:06:16', 'high', 'to do', 10, 13),
(10, 'Задание #2 тоже для сидора', 'Давно выяснено, что при оценке дизайна и композиции читаемый текст мешает сосредоточиться. Lorem Ipsum используют потому, что тот обеспечивает более или менее стандартное заполнение шаблона,', '2021-05-26', '2021-05-06', '2021-05-22 16:37:23', 'high', 'to do', 10, 13);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `firstname` longtext NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `hash` varchar(100) NOT NULL,
  `role` enum('user','manager','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'user',
  `auth_key` varchar(100) NOT NULL,
  `depend` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `patronymic`, `login`, `hash`, `role`, `auth_key`, `depend`) VALUES
(10, 'Иванов', 'Иван', 'Иванович', 'ivan', '$2y$13$n0qelZaQL9bJhV0bjlOe/eROYwAE/dC27EWfCohKy6bwRSIWuiQ9a', 'manager', '3eKAtzSSA9Nmhlq9cb6fp-0dtrq2XHtG', NULL),
(11, 'Администратор', 'Главный', 'Самый', 'admin', '$2y$13$wZkjue35.qbUEkNPQkgpXev2pkX0h1me/hdv69aDq0QMoMF.5ivy2', 'admin', 'Ox8iJxgj-VLOmWmAr-krlGNxR_nzh-wD', NULL),
(12, 'Петр', 'Петров', 'Петрович', 'petrov', '$2y$13$.nn5gfwwI1HCSxScqz2JNu7UuWT4/V06Qhhw9Ev774JvfQ.PuXSW2', 'user', 'EN9Om7oKvspFhTJGnQVPqoEx1cRpjnv2', 10),
(13, 'Сидор', 'Сидоров', 'Сидорович', 'sidor', '$2y$13$7nKm.wAv2tT.Ys0b/P63PuoqItgKgat.Na8LYFR.f9EsaBVmGUWVW', 'user', 'z1EdorCtPmrIhT7_V4qomuWSsCt8h-b-', 10);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator_user` (`creator_user`),
  ADD KEY `tasks_ibfk_2` (`responsible_user`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `depend` (`depend`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`creator_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tasks_ibfk_2` FOREIGN KEY (`responsible_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`depend`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
