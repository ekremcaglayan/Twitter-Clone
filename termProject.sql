-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 11 Haz 2023, 11:56:47
-- Sunucu sürümü: 8.0.31
-- PHP Sürümü: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `termProject`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `Followers`
--

CREATE TABLE `Followers` (
  `FollowerID` int NOT NULL,
  `FollowingID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `Followers`
--

INSERT INTO `Followers` (`FollowerID`, `FollowingID`) VALUES
(1, 1),
(3, 1),
(9, 1),
(1, 3),
(9, 3),
(1, 4),
(1, 5),
(1, 9);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `Tweets`
--

CREATE TABLE `Tweets` (
  `TweetID` int NOT NULL,
  `UserID` int DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `Tweets`
--

INSERT INTO `Tweets` (`TweetID`, `UserID`, `content`, `date`) VALUES
(1, 1, 'merhabalar ben Ekrem', '2023-06-10 12:01:51'),
(12, 3, 'selam ben Mehmet', '2023-06-10 12:02:50'),
(13, 1, 'ben ekrem 2. tweetim', '2023-06-10 12:37:59'),
(14, 1, '3. tweetim', '2023-06-10 13:18:43'),
(15, 9, 'merhabalar ben füsun', '2023-06-10 13:25:58');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `UserID` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `creation_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`UserID`, `username`, `name`, `password`, `creation_date`) VALUES
(1, 'ekremcaglayan', 'Ekrem Caglayan', '12345', '2023-06-01 23:35:36'),
(3, 'mehmetsemdin', 'Mehmet ', '12345', '2023-06-01 23:35:36'),
(4, 'aliberkislam', 'aliberk', '12345', '2023-06-04 18:28:23'),
(5, 'edatan', 'eda', '12345', '2023-06-09 18:44:28'),
(9, 'fusuncaglayan', 'fusun', '12345', '2023-06-10 13:25:26');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `Followers`
--
ALTER TABLE `Followers`
  ADD PRIMARY KEY (`FollowerID`,`FollowingID`),
  ADD KEY `FollowingID` (`FollowingID`);

--
-- Tablo için indeksler `Tweets`
--
ALTER TABLE `Tweets`
  ADD PRIMARY KEY (`TweetID`),
  ADD KEY `UserID` (`UserID`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `Tweets`
--
ALTER TABLE `Tweets`
  MODIFY `TweetID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `Followers`
--
ALTER TABLE `Followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`FollowerID`) REFERENCES `Users` (`UserID`),
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`FollowingID`) REFERENCES `Users` (`UserID`);

--
-- Tablo kısıtlamaları `Tweets`
--
ALTER TABLE `Tweets`
  ADD CONSTRAINT `tweets_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
