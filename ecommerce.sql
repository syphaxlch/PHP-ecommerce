-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 31 mai 2022 à 20:21
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecommerce`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id_admin` int(11) NOT NULL,
  `nom` varchar(11) NOT NULL,
  `prenom` varchar(11) NOT NULL,
  `email` varchar(11) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Acceuil'),
(2, 'Smartphones'),
(3, 'Ordinateurs'),
(4, 'Accessoires');

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` float NOT NULL,
  `image` varchar(250) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `price`, `image`, `category`) VALUES
(1, 'Antichoc', 'Antichoc S10 5G, A90 5G, OPPO A54, <br>\r\nRedmi Note8 Pro, Redmi 9A, Samsung A02S…..etc', 600, 'antichoc.jpg', 4),
(2, 'Air buds', 'airpods Hoco,Lenovo,Realme', 1000, 'airbuds.jpg', 4),
(3, 'dell latitude e7250\r\n', 'ram: 8gb ddr3\r\nstockage: 256go ssd\r\ngraphique: intel hd graphics 620\r\n\r\n', 78000, 'pcdell.jpg', 1),
(4, 'Skin Alvin', 'SKIN personnalisé Alvin<br>\r\nHydrogel<br>\r\nArrière\r\n', 4000, 'Skinalvin.jpg', 1),
(5, 'smartwatch T500', 'Batterie: 180 mAh <br>\r\nLecture bluetooth <br>\r\nPrise en charge Android et iOS', 4700, 'smartwatch.jpg', 1),
(6, 'iphone Xs', 'Ram:4go <br>\r\nMemoire:64 go', 65000, 'iphonexs.JPG', 1),
(7, 'hp probook 430 g5', 'Ram: 8 gb ddr4 2133mhZ<br>\r\nStockage: 256 go ssd<br>\r\nGraphique: intel uhd graphics 620<br>\r\nLecteur carte sd ', 112000, 'pchp.jpg', 3),
(8, 'apple  macbook', 'GPU 14, 16 ou 32 cœurs <br>\r\nJusqu\'à 64 Go de mémoire unifiée <br>\r\nJusqu’à 2 To de stockage <br>\r\nMagic Keyboard avec Touch ID <br>', 105000, 'macbook.jpeg', 3),
(9, 'ACER SF 114-34', 'Processeur Intel® Pentium® Silver N6000 Quad-core <br>\r\n4 Go <br>\r\n256 Go SSD <br>\r\nIntel® UHD Graphics avec mémoire partagée <br>  ', 153000, 'pcacer.jpg', 3),
(10, 'Samsung S10 5g', 'Ram: 8go <br>\r\nBatterie: 3400 mAh <br>\r\nCamera: 12Mpx <br>', 105000, 'S10.jpg', 2),
(11, 'S20 FE ', 'ram: 6go, 8go <br>\r\nbatterie: 4500mAH <br>\r\ncamera: 12Mpx <br>\r\nprocesseur: Exynos 990 samsung <br>\r\n', 105000, 's20fe.jpg', 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `telephone` int(11) DEFAULT NULL,
  `Firstname` varchar(255) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `admin_user` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `telephone`, `Firstname`, `Name`, `admin_user`) VALUES
(4, 'qqq1@gmail.com', '$2y$10$ZqLqJN9fHjMyN8anwPxVWOX2MJZG3XAVcCdXn8n820IRM.ZgnDwz2', 123, 'admin', 'admin', 1),
(5, 'qqqq1@gmail.com', '$2y$10$Rq.z4FFdwgaUbmJqIPc3YenKvlywnAVJqCazIwyDxzfLMuBa8lA3S', 12345, 'sss', 'sss', NULL),
(6, '12345@gmail.com', '$2y$10$l9RS9liT4KDrnqz0QPNXf.NMAPcBECFBDb3mTalibjBDrmyXxzvoG', 123, 'sss', 'sifax', NULL),
(7, '1234@gmail.com', '$2y$10$JqfXjmKsChFhKvAmKzfsk.S7lyP7ZV5da4mRbmMquhbZ9u1dx2o0u', 123, 'sss', 'sifax', NULL),
(8, '123@gmail.com', '$2y$10$5AtvENGime9x4DZj9viFO.rOtsWyr3gQEQ97opNJEUqxJn/xqxm3S', 123, 'sss', 'sifax', NULL),
(9, '1239@gmail.com', '$2y$10$VoFuwhDJpzPsPbYpDpMPE.skiz7haOqvypTyVWoPfZCXCmMFosNmy', 123, 'sss', 'sifax', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
