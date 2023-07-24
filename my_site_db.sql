-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:8889
-- Время создания: Июл 24 2023 г., 14:30
-- Версия сервера: 5.7.39
-- Версия PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `my_site_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE `items` (
  `itemId` int(11) NOT NULL,
  `itemCategory` varchar(100) NOT NULL,
  `itemSubCategory` varchar(120) NOT NULL,
  `itemName` varchar(128) NOT NULL,
  `itemPrice` int(11) NOT NULL,
  `itemAmount` int(11) NOT NULL,
  `picLink` varchar(256) DEFAULT NULL,
  `itemDescription` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`itemId`, `itemCategory`, `itemSubCategory`, `itemName`, `itemPrice`, `itemAmount`, `picLink`, `itemDescription`) VALUES
(1, 'socks', 'memes', 'Apple Kittens Socks', 5, 15, 'socks-kitty.png', 'Socks with cute apple kittens won\'t let you feel sad and depressed.'),
(2, 'socks', 'memes', 'Meme \'ЪyЪ\' Cat Socks', 5, 20, 'socks_meme_cat.png', 'Feel ЪyЪ-y? Than these socks with adorable cat are just what you need.'),
(3, 'socks', 'memes', 'This Is Fine Socks', 6, 7, 'thats_fine.png', '40C˚ outside? Burning deadlines? Lack of sleep? No will to explain it to others? This Is Fine Socks will do it for you!'),
(4, 'socks', 'basic', 'Basic White Socks', 3, 26, 'basic_white.png', 'Just Basic. Just White. Just Perfect.'),
(5, 'socks', 'basic', 'Basic Orange Socks', 3, 27, 'orange_socks.png', 'Bored of classic socks? Want to be stylish even in office costume? Orange Basic Socks are the key!'),
(6, 'socks', 'pattern', 'Chess Socks', 5, 12, 'chess_socks.png', 'No Chess - no SOCKcess'),
(7, 'headwear', 'panama', 'Black Panama', 23, 16, 'black_panama.png', '\"Mom, I really wear a hat\"'),
(8, 'headwear', 'panama', 'White Panama', 23, 12, 'white_panama.png', '\"Mom, I really wear a hat\"'),
(9, 'headwear', 'panama', 'Colored Panama', 27, 16, 'color_panama.png', '\"Mom, I really wear a hat\"'),
(10, 'card', 'card', '50€ Gift Card', 50, 10, 'card50.png', 'This card can be used several times and can be used partially. It does not add up with other discounts.'),
(11, 'card', 'card', '100€ Gift Card', 100, 9, 'card100.png', 'This card can be used several times and can be used partially. It does not add up with other discounts.');

-- --------------------------------------------------------

--
-- Структура таблицы `orderedItems`
--

CREATE TABLE `orderedItems` (
  `lineId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  `itemsAmount` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `itemSize` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orderedItems`
--

INSERT INTO `orderedItems` (`lineId`, `itemId`, `itemsAmount`, `orderId`, `itemSize`) VALUES
(5, 2, 1, 2, 0),
(6, 6, 2, 2, 0),
(7, 1, 2, 2, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `orderId` int(100) NOT NULL,
  `userId` int(11) NOT NULL,
  `orderAmount` int(20) NOT NULL,
  `orderTotal` int(255) NOT NULL,
  `orderStatus` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`orderId`, `userId`, `orderAmount`, `orderTotal`, `orderStatus`) VALUES
(2, 2, 5, 25, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `postId` int(11) NOT NULL,
  `postCategory` varchar(128) DEFAULT NULL,
  `postTitle` varchar(128) NOT NULL,
  `postPicLink` varchar(255) NOT NULL,
  `postText` text NOT NULL,
  `postDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`postId`, `postCategory`, `postTitle`, `postPicLink`, `postText`, `postDate`) VALUES
(1, NULL, 'Why SOCKCESS?', 'post1.png', 'Some text for post1', '2023-07-20'),
(2, 'pattern', 'Socks for this summer', 'post2.png', 'New arrivals! Go and check out cool socks that would suit you the most this summer!', '2023-07-24'),
(3, NULL, 'Why socks with memes became popular?', 'post3.png', 'We\'ve conducted a survey and found out most common reasons why socks with memes are cool.', '2023-07-24'),
(4, NULL, 'Express yourself with SOCKCESS!', 'post5.png', 'Look stylish and fresh even in office, school and uni with our socks!', '2023-07-24'),
(5, 'memes', 'Socks with memes with memes will never be enough', 'post4.png', 'New arrivals in catigory \'With memes\'', '2023-07-24');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `usersId` int(11) NOT NULL,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersUid` varchar(128) NOT NULL,
  `usersPwd` varchar(128) NOT NULL,
  `usersLevel` int(1) NOT NULL,
  `deliveryAddress` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`usersId`, `usersName`, `usersEmail`, `usersUid`, `usersPwd`, `usersLevel`, `deliveryAddress`) VALUES
(1, 'Admin1', 'admin1@admin.com', 'admin1', '$2y$10$pLrXUZIFFIFyOsppRWHt6OeI7vKOwZDexe.MZiZ0OczGqGaNR01dK', 1, NULL),
(2, 'A', 'a@a.a', 'a', '$2y$10$pwHudcEsCzM3c3xJzXSeFu5NS3KxBP7ouogzctHE0Po6GDT4zItWe', 0, NULL),
(3, 'B', 'b@b.b', 'b', '$2y$10$k6P37.Nky7IqA0ybOBRAPesKml/YeDuYkbhc5VNUBbq/6NrVykHcO', 0, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemId`);

--
-- Индексы таблицы `orderedItems`
--
ALTER TABLE `orderedItems`
  ADD PRIMARY KEY (`lineId`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postId`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersId`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `items`
--
ALTER TABLE `items`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `orderedItems`
--
ALTER TABLE `orderedItems`
  MODIFY `lineId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `postId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `usersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
