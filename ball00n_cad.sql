-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Мар 26 2021 г., 20:51
-- Версия сервера: 5.7.21-20-beget-5.7.21-20-1-log
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ball00n_cad`
--

-- --------------------------------------------------------

--
-- Структура таблицы `calls`
--
-- Создание: Фев 19 2021 г., 16:53
-- Последнее обновление: Мар 26 2021 г., 12:38
--

DROP TABLE IF EXISTS `calls`;
CREATE TABLE `calls` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `location` text NOT NULL,
  `active` int(11) NOT NULL,
  `log` text NOT NULL,
  `last_calls_update` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `log`
--
-- Создание: Фев 19 2021 г., 16:53
-- Последнее обновление: Мар 26 2021 г., 17:49
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `log_ip` text NOT NULL,
  `log_time` int(11) NOT NULL,
  `log_action` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ncic`
--
-- Создание: Фев 19 2021 г., 16:53
-- Последнее обновление: Мар 26 2021 г., 12:37
--

DROP TABLE IF EXISTS `ncic`;
CREATE TABLE `ncic` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `dob` text NOT NULL,
  `sex` text NOT NULL,
  `race` text NOT NULL,
  `marrital_status` text NOT NULL,
  `por` text NOT NULL,
  `creator` text NOT NULL,
  `skin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ncic_arrests`
--
-- Создание: Фев 19 2021 г., 16:53
-- Последнее обновление: Мар 26 2021 г., 12:37
--

DROP TABLE IF EXISTS `ncic_arrests`;
CREATE TABLE `ncic_arrests` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `reason` text NOT NULL,
  `date` int(11) NOT NULL,
  `creator` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ncic_violations`
--
-- Создание: Фев 19 2021 г., 16:53
-- Последнее обновление: Мар 26 2021 г., 12:37
--

DROP TABLE IF EXISTS `ncic_violations`;
CREATE TABLE `ncic_violations` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `reason` text NOT NULL,
  `date` int(11) NOT NULL,
  `creator` text NOT NULL,
  `place` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ncic_warnings`
--
-- Создание: Фев 19 2021 г., 16:53
-- Последнее обновление: Мар 26 2021 г., 12:38
--

DROP TABLE IF EXISTS `ncic_warnings`;
CREATE TABLE `ncic_warnings` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `reason` text NOT NULL,
  `date` int(11) NOT NULL,
  `creator` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--
-- Создание: Фев 19 2021 г., 16:53
-- Последнее обновление: Мар 26 2021 г., 17:49
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `panic_active` int(11) NOT NULL,
  `signal_100` int(11) NOT NULL,
  `last_notifications_update` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `people_bolo`
--
-- Создание: Фев 19 2021 г., 16:53
-- Последнее обновление: Мар 26 2021 г., 12:38
--

DROP TABLE IF EXISTS `people_bolo`;
CREATE TABLE `people_bolo` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `surname` text NOT NULL,
  `sex` text NOT NULL,
  `description` text NOT NULL,
  `reason` text NOT NULL,
  `active` int(11) NOT NULL,
  `last_bolo_update` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--
-- Создание: Фев 20 2021 г., 15:59
-- Последнее обновление: Мар 26 2021 г., 17:49
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `session_id` char(32) NOT NULL,
  `session_user_id` int(11) NOT NULL,
  `session_ip` varchar(40) NOT NULL,
  `session_browser` varchar(250) NOT NULL,
  `session_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions_keys`
--
-- Создание: Фев 19 2021 г., 16:53
-- Последнее обновление: Мар 26 2021 г., 17:49
--

DROP TABLE IF EXISTS `sessions_keys`;
CREATE TABLE `sessions_keys` (
  `key_id` char(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_ip` varchar(40) NOT NULL,
  `last_login` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `units`
--
-- Создание: Фев 19 2021 г., 17:22
-- Последнее обновление: Мар 26 2021 г., 17:49
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` int(5) NOT NULL,
  `username` varchar(30) CHARACTER SET utf8 NOT NULL,
  `win` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `proc` varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '0',
  `coordx` varchar(50) NOT NULL,
  `coordy` varchar(50) NOT NULL,
  `coordtime` varchar(50) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--
-- Создание: Фев 19 2021 г., 16:53
-- Последнее обновление: Мар 26 2021 г., 17:45
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `status` text NOT NULL,
  `active_call` int(11) NOT NULL,
  `notification` int(11) NOT NULL,
  `identifier` text NOT NULL,
  `type` int(11) NOT NULL,
  `activation` int(11) NOT NULL,
  `activation_code` text NOT NULL,
  `last_user_update` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `vehicle_bolo`
--
-- Создание: Фев 19 2021 г., 16:53
-- Последнее обновление: Мар 26 2021 г., 17:49
--

DROP TABLE IF EXISTS `vehicle_bolo`;
CREATE TABLE `vehicle_bolo` (
  `id` int(11) NOT NULL,
  `model` text NOT NULL,
  `color` text NOT NULL,
  `number` text NOT NULL,
  `features` text NOT NULL,
  `last_place` text NOT NULL,
  `last_date` text NOT NULL,
  `reason` text NOT NULL,
  `active` int(11) NOT NULL,
  `last_bolo_update` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `calls`
--
ALTER TABLE `calls`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ncic`
--
ALTER TABLE `ncic`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ncic_arrests`
--
ALTER TABLE `ncic_arrests`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ncic_violations`
--
ALTER TABLE `ncic_violations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ncic_warnings`
--
ALTER TABLE `ncic_warnings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`panic_active`);

--
-- Индексы таблицы `people_bolo`
--
ALTER TABLE `people_bolo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Индексы таблицы `sessions_keys`
--
ALTER TABLE `sessions_keys`
  ADD PRIMARY KEY (`key_id`,`user_id`);

--
-- Индексы таблицы `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `vehicle_bolo`
--
ALTER TABLE `vehicle_bolo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `calls`
--
ALTER TABLE `calls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ncic`
--
ALTER TABLE `ncic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ncic_arrests`
--
ALTER TABLE `ncic_arrests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ncic_violations`
--
ALTER TABLE `ncic_violations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ncic_warnings`
--
ALTER TABLE `ncic_warnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `people_bolo`
--
ALTER TABLE `people_bolo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `units`
--
ALTER TABLE `units`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `vehicle_bolo`
--
ALTER TABLE `vehicle_bolo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
