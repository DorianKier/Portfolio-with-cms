-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 16 Maj 2021, 19:25
-- Wersja serwera: 10.4.18-MariaDB
-- Wersja PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `portfolio`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `body`
--

CREATE TABLE `body` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `content` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `body`
--

INSERT INTO `body` (`id`, `name`, `content`) VALUES
(1, 'header', 'Twoja nazwa portfolio'),
(2, 'footer', ''),
(3, 'contact', '123-456-789'),
(4, 'social_media', '<i class=\"icon-facebook\"></i>fb<br/>\r\n<i class=\"icon-twitter\"></i>tw<br/>\r\n<i class=\"icon-github\"></i>github<br/>');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `head`
--

CREATE TABLE `head` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `content` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `head`
--

INSERT INTO `head` (`id`, `name`, `content`) VALUES
(1, 'title', 'Twoje portfolio');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `main`
--

CREATE TABLE `main` (
  `id` int(11) NOT NULL,
  `nav` int(11) NOT NULL,
  `content` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `main`
--

INSERT INTO `main` (`id`, `nav`, `content`) VALUES
(1, 1, 'Witaj, jestem początkującym programistą'),
(2, 2, 'Tutaj wpisz swoje projekty...\r\n'),
(3, 3, 'Tutaj umieść preferowane sposoby kontaktu\r\n');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nav`
--

CREATE TABLE `nav` (
  `id` int(11) NOT NULL,
  `nav` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `nav`
--

INSERT INTO `nav` (`id`, `nav`) VALUES
(1, 'home'),
(2, 'projekty'),
(3, 'kontakt');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `style`
--

CREATE TABLE `style` (
  `id` int(11) NOT NULL,
  `style` text COLLATE utf8_polish_ci NOT NULL,
  `content` text COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `style`
--

INSERT INTO `style` (`id`, `style`, `content`) VALUES
(1, 'background', ''),
(2, 'font', ''),
(3, 'font-family', ''),
(4, 'link-to-font', ''),
(5, 'background-nav\r\n', ''),
(6, 'font-nav', ''),
(7, 'background-main', ''),
(8, 'font-main', ''),
(9, 'background-navh', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `imie` text COLLATE utf8_polish_ci NOT NULL,
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `haslo` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `imie`, `login`, `haslo`) VALUES
(1, 'Admin', 'admin', 'b4aea89852598dac6b23ad25097f87f79e9da57fa781835af883eed803345723');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `body`
--
ALTER TABLE `body`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `head`
--
ALTER TABLE `head`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `main`
--
ALTER TABLE `main`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nav` (`nav`);

--
-- Indeksy dla tabeli `nav`
--
ALTER TABLE `nav`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `style`
--
ALTER TABLE `style`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `body`
--
ALTER TABLE `body`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `head`
--
ALTER TABLE `head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `main`
--
ALTER TABLE `main`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `nav`
--
ALTER TABLE `nav`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `style`
--
ALTER TABLE `style`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `main`
--
ALTER TABLE `main`
  ADD CONSTRAINT `main_ibfk_1` FOREIGN KEY (`nav`) REFERENCES `nav` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
