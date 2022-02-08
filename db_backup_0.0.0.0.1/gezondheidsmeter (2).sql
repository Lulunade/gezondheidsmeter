-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 31 okt 2021 om 19:20
-- Serverversie: 10.4.20-MariaDB
-- PHP-versie: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gezondheidsmeter`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `antwoord`
--

CREATE TABLE `antwoord` (
  `ID` int(11) NOT NULL,
  `Gebruiker_ID` int(11) NOT NULL,
  `Vraag_ID` int(11) NOT NULL,
  `Antwoord` text NOT NULL,
  `Score` decimal(10,0) NOT NULL,
  `Datum` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorie`
--

CREATE TABLE `categorie` (
  `ID` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `categorie`
--

INSERT INTO `categorie` (`ID`, `naam`) VALUES
(3, 'Arbeidsomstandigheden'),
(4, 'Sport en bewegen'),
(5, 'Voeding en alcohol'),
(6, 'Drugs'),
(7, 'Slaap');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruiker`
--

CREATE TABLE `gebruiker` (
  `ID` int(11) NOT NULL,
  `Naam` varchar(255) NOT NULL,
  `Geslacht` varchar(255) NOT NULL,
  `Lengte` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Gewicht` double NOT NULL,
  `Wachtwoord` varchar(255) NOT NULL,
  `Leeftijd` int(11) NOT NULL,
  `admin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `gebruiker`
--

INSERT INTO `gebruiker` (`ID`, `Naam`, `Geslacht`, `Lengte`, `email`, `Gewicht`, `Wachtwoord`, `Leeftijd`, `admin`) VALUES
(15, 'Milan', '', '', 'milan@example.com', 0, '$2y$10$NOSjBTCIoea/0nV035Y6PO/glNOUM/9QKnGL8.4YqP0OBRyxkNQne', 18, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vraag`
--

CREATE TABLE `vraag` (
  `ID` int(11) NOT NULL,
  `Categorie_ID` int(11) NOT NULL,
  `Vraag` text NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `vraag`
--

INSERT INTO `vraag` (`ID`, `Categorie_ID`, `Vraag`, `type`) VALUES
(33, 3, 'WIsselt u regelmatig van werkhouding', 'multiple'),
(34, 3, 'Is uw werkruimte goed geventileerrd', 'multiple'),
(35, 3, 'Hoe is de verlichting in uw werkruimte', 'multiple'),
(38, 3, 'Hoe is de balans tussen werk en privé zaken', 'multiple'),
(39, 4, 'Hoeveel minuten heb je vandaag gesport', 'multiple'),
(40, 5, 'Heb je vandaag iets gegeten uit de volgende categorieën', 'checklist'),
(41, 5, 'Heb je vandaag een van deze dranken genuttigd?', 'checklist'),
(42, 5, 'Hoeveel ml alcohol heb je vandaag genuttigd', 'multiple'),
(43, 6, 'Welke drugs heb je vandaag genuttigd', 'checklist'),
(44, 7, 'Ongeveer hoeveel uur slaap heb je gehad', 'multiple');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vraag_antwoord`
--

CREATE TABLE `vraag_antwoord` (
  `ID` int(11) NOT NULL,
  `Vraag_ID` int(11) NOT NULL,
  `Antwoord` text NOT NULL,
  `Weging` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `vraag_antwoord`
--

INSERT INTO `vraag_antwoord` (`ID`, `Vraag_ID`, `Antwoord`, `Weging`) VALUES
(1, 33, 'Ja', '2.00'),
(2, 33, 'Nee', '0.00'),
(3, 34, 'Ja', '2.00'),
(4, 34, 'Nee', '0.00'),
(9, 35, 'Niet', '0.00'),
(10, 35, 'Slecht', '0.75'),
(11, 35, 'Redelijk', '1.25'),
(12, 35, 'Goed', '2.00'),
(13, 38, 'Goed', '1.50'),
(14, 38, 'Redelijk', '1.00'),
(15, 38, 'Slecht', '0.50'),
(16, 38, 'Heel goed', '2.00'),
(17, 39, 'Geen', '0.00'),
(18, 39, '30 tot 60', '2.00'),
(19, 39, '180 of meer', '0.50'),
(20, 39, '15 tot 30', '1.00'),
(21, 40, 'Groente & Fruit', '1.50'),
(22, 40, 'Smeer- en bereidingsvetten', '1.50'),
(23, 40, 'Vis, peulvruchten, vlees, ei, noten, zuivel', '1.50'),
(24, 40, 'Brood, graanproducten, aardappelen', '1.50'),
(25, 41, 'Water', '2.00'),
(26, 41, 'Frisdrank', '0.50'),
(27, 41, 'Smoothie', '1.25'),
(28, 41, 'Thee', '1.75'),
(29, 41, 'Koffie', '1.00'),
(30, 41, 'Energie drank', '0.00'),
(31, 42, '0', '2.00'),
(32, 42, '50 - 100', '1.00'),
(33, 42, '100 - 300', '0.50'),
(34, 42, 'Meer dan 300', '0.00'),
(35, 43, 'Joints', '0.00'),
(36, 43, 'Sigaretten', '0.00'),
(37, 43, 'sigaren', '0.00'),
(38, 43, 'Exctacy', '0.00'),
(39, 43, 'Coke', '0.00'),
(40, 43, 'Speed', '0.00'),
(41, 43, 'MDMA', '0.00'),
(42, 43, 'Lachgas', '0.00'),
(43, 44, '6 tot 8', '2.00'),
(44, 44, '8 of meer', '1.50'),
(45, 44, '0 tot 3', '0.50'),
(46, 44, '3 tot 6', '1.00');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `antwoord`
--
ALTER TABLE `antwoord`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `gebruiker` (`Gebruiker_ID`),
  ADD KEY `Vraag` (`Vraag_ID`);

--
-- Indexen voor tabel `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD PRIMARY KEY (`ID`);

--
-- Indexen voor tabel `vraag`
--
ALTER TABLE `vraag`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `category` (`Categorie_ID`);

--
-- Indexen voor tabel `vraag_antwoord`
--
ALTER TABLE `vraag_antwoord`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `vraag id` (`Vraag_ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `antwoord`
--
ALTER TABLE `antwoord`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT voor een tabel `categorie`
--
ALTER TABLE `categorie`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `gebruiker`
--
ALTER TABLE `gebruiker`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `vraag`
--
ALTER TABLE `vraag`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT voor een tabel `vraag_antwoord`
--
ALTER TABLE `vraag_antwoord`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `antwoord`
--
ALTER TABLE `antwoord`
  ADD CONSTRAINT `Vraag` FOREIGN KEY (`Vraag_ID`) REFERENCES `vraag` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gebruiker` FOREIGN KEY (`Gebruiker_ID`) REFERENCES `gebruiker` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `vraag`
--
ALTER TABLE `vraag`
  ADD CONSTRAINT `category` FOREIGN KEY (`Categorie_ID`) REFERENCES `categorie` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `vraag_antwoord`
--
ALTER TABLE `vraag_antwoord`
  ADD CONSTRAINT `vraag id` FOREIGN KEY (`Vraag_ID`) REFERENCES `vraag` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
