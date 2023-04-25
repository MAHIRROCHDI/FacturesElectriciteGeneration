-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 06 mars 2023 à 23:37
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `facturationelectric`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `idAdmin` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`idAdmin`, `username`, `password`) VALUES
(8, 'admin', '$2y$10$sKxBV6WeVNkpOwEPFjGxBuK/thgyrT7gh9.IapXRi4KTRNpi8f3Dm');

-- --------------------------------------------------------

--
-- Structure de la table `agent`
--

CREATE TABLE `agent` (
  `idAgent` int(11) NOT NULL,
  `numeroAgent` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `idZone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `agent`
--

INSERT INTO `agent` (`idAgent`, `numeroAgent`, `password`, `idZone`) VALUES
(2, 'AgentMhanech', 'agent1', 1),
(3, 'AgentTota', 'agent2', 3),
(4, 'AgentSaniaRmenl', 'agent3', 4),
(5, 'AgentMedina', 'agent4', 5),
(6, 'AgentKwilma', 'agent5', 6),
(7, 'AgentTabola', 'agent6', 7),
(8, 'AgentBoenane', 'agent7', 8);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `idClient` int(11) NOT NULL,
  `cin` varchar(30) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zone_geo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`idClient`, `cin`, `nom`, `prenom`, `password`, `address`, `zone_geo`) VALUES
(21, 'L1111', 'MAHIR', 'Rochdi', '$2y$10$bjFb1tIjRyG7hA2z2/wbq./DzkDkNtfYQaHA7LZrnd.I7.j97qFfi', '55 AV MARRAKECH , 93000 TETOUAN', 3),
(22, 'L2222', 'HAMID', 'Rabie', '$2y$10$X1t9enWjde3Kah4q70IdnuYLp2tjsQt93EUxwN7Rmn/291hGZchPm', '55 AV fes, 93000 TETOUAN', 3),
(23, 'L3333', 'SOLAYMANE', 'Flan', '$2y$10$MaT/5wwtqa1vszV43C1m0.1BA7R8w291ZA4hjNZAKspO15Sski/Fe', '55 AV Rachidia, 93000 TETOUAN', 1),
(24, 'L4444', 'AMIR', 'Abdo', '$2y$10$CyS7u5BXTBCAG9Od1Fe/1uTNY6P2PVBi78TwWoqoZzNNYmDk8R3B6', '55 AV IFRAN, 93000 TETOUAN', 1),
(25, 'L5555', 'OMAR', 'Yassin', '$2y$10$b0IedlKf0ABGKj8XxwcDJ.6KU7xti35w6e5Wr1lHQXv8zTaG1JtzC', '67 AV DODA, 93000 TETOUAN', 8);

-- --------------------------------------------------------

--
-- Structure de la table `consomation`
--

CREATE TABLE `consomation` (
  `idConsomation` int(11) NOT NULL,
  `idClient` int(11) NOT NULL,
  `consomationConteur` double NOT NULL,
  `mois` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `compteurImg` varchar(255) NOT NULL,
  `previousConsomationComp` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `consomation`
--

INSERT INTO `consomation` (`idConsomation`, `idClient`, `consomationConteur`, `mois`, `annee`, `compteurImg`, `previousConsomationComp`) VALUES
(41, 21, 300, 1, 2022, 'images (1).png', 0),
(43, 21, 480, 2, 2022, 'images (1).png', 300),
(44, 21, 700, 3, 2022, 'istockphoto-1201144331-612x612.jpg', 480),
(45, 21, 1000, 4, 2022, 'images.png', 700),
(47, 21, 1200, 5, 2022, 'images.png', 1000),
(48, 21, 1400, 6, 2022, 'Untitled (9).jpg', 1200),
(49, 21, 1500, 7, 2022, 'images.png', 1400),
(50, 21, 1900, 8, 2022, 'Dashboard (1).png', 1500),
(52, 21, 2000, 9, 2022, 'istockphoto-1201144331-612x612.jpg', 1900),
(53, 21, 2200, 10, 2022, 'images.png', 2000),
(54, 21, 2500, 11, 2022, 'images.png', 2200),
(58, 22, 3000, 11, 2022, 'istockphoto-1201144331-612x612.jpg', 0),
(59, 22, 3400, 12, 2022, 'images.png', 3000),
(62, 21, 2901, 12, 2022, 'images.png', 2500);

-- --------------------------------------------------------

--
-- Structure de la table `consomationann`
--

CREATE TABLE `consomationann` (
  `idConAnn` int(11) NOT NULL,
  `idClient` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `consomationAnn` double NOT NULL,
  `comnsomationAnnParAgent` double NOT NULL,
  `dateSaisir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `consomationann`
--

INSERT INTO `consomationann` (`idConAnn`, `idClient`, `annee`, `consomationAnn`, `comnsomationAnnParAgent`, `dateSaisir`) VALUES
(6, 21, 2022, 2901, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `idFacture` int(11) NOT NULL,
  `idClient` int(11) NOT NULL,
  `idConsomation` int(11) NOT NULL,
  `dateFacture` date NOT NULL,
  `montantTTC` double NOT NULL,
  `montantHT` double NOT NULL,
  `mois` int(11) NOT NULL,
  `consomationMensuel` double NOT NULL,
  `valide` varchar(10) NOT NULL DEFAULT 'non'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `facture`
--

INSERT INTO `facture` (`idFacture`, `idClient`, `idConsomation`, `dateFacture`, `montantTTC`, `montantHT`, `mois`, `consomationMensuel`, `valide`) VALUES
(31, 21, 41, '2022-01-30', 383.04, 336, 1, 300, 'oui'),
(33, 21, 43, '2022-02-28', 207.252, 181.8, 2, 180, 'oui'),
(34, 21, 44, '2022-03-28', 280.896, 246.4, 3, 220, 'oui'),
(35, 21, 45, '2022-04-28', 383.04, 336, 4, 300, 'oui'),
(37, 21, 47, '2022-05-28', 230.28, 202, 5, 200, 'oui'),
(38, 21, 48, '2022-06-28', 230.28, 202, 6, 200, 'oui'),
(39, 21, 49, '2022-07-28', 103.74, 91, 7, 100, 'oui'),
(40, 21, 50, '2022-08-28', 510.72, 448, 8, 400, 'oui'),
(42, 21, 52, '2022-09-28', 103.74, 91, 9, 100, 'oui'),
(43, 21, 53, '2022-10-28', 230.28, 202, 10, 200, 'oui'),
(44, 21, 54, '2022-11-28', 383.04, 336, 11, 300, 'oui'),
(48, 22, 58, '2022-11-28', 3830.4, 3360, 11, 3000, 'non'),
(52, 21, 62, '2022-12-28', 511.9968, 449.12, 12, 401, 'oui');

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `idReclamation` int(11) NOT NULL,
  `idClient` int(11) NOT NULL,
  `dateReclamation` date NOT NULL,
  `typeReclamation` varchar(255) NOT NULL,
  `contenueRec` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'non_traiter'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `zonegeographique`
--

CREATE TABLE `zonegeographique` (
  `idZone` int(11) NOT NULL,
  `nomZone` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `zonegeographique`
--

INSERT INTO `zonegeographique` (`idZone`, `nomZone`) VALUES
(1, 'Mhanech'),
(3, 'TOTA'),
(4, 'Sania Rmel'),
(5, 'Medina'),
(6, 'Kwilma'),
(7, 'Tabola'),
(8, 'Boenane');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Index pour la table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`idAgent`),
  ADD KEY `idZone` (`idZone`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`),
  ADD UNIQUE KEY `cin` (`cin`),
  ADD KEY `zone_geo` (`zone_geo`);

--
-- Index pour la table `consomation`
--
ALTER TABLE `consomation`
  ADD PRIMARY KEY (`idConsomation`),
  ADD KEY `idClient` (`idClient`);

--
-- Index pour la table `consomationann`
--
ALTER TABLE `consomationann`
  ADD PRIMARY KEY (`idConAnn`),
  ADD KEY `idClient` (`idClient`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`idFacture`),
  ADD KEY `idClient` (`idClient`),
  ADD KEY `idConsomation` (`idConsomation`);

--
-- Index pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`idReclamation`),
  ADD KEY `idClient` (`idClient`);

--
-- Index pour la table `zonegeographique`
--
ALTER TABLE `zonegeographique`
  ADD PRIMARY KEY (`idZone`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `agent`
--
ALTER TABLE `agent`
  MODIFY `idAgent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `consomation`
--
ALTER TABLE `consomation`
  MODIFY `idConsomation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `consomationann`
--
ALTER TABLE `consomationann`
  MODIFY `idConAnn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `idFacture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `idReclamation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `zonegeographique`
--
ALTER TABLE `zonegeographique`
  MODIFY `idZone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `agent`
--
ALTER TABLE `agent`
  ADD CONSTRAINT `agent_ibfk_1` FOREIGN KEY (`idZone`) REFERENCES `zonegeographique` (`idZone`);

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`zone_geo`) REFERENCES `zonegeographique` (`idZone`);

--
-- Contraintes pour la table `consomation`
--
ALTER TABLE `consomation`
  ADD CONSTRAINT `consomation_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`);

--
-- Contraintes pour la table `consomationann`
--
ALTER TABLE `consomationann`
  ADD CONSTRAINT `consomationann_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`);

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `facture_ibfk_2` FOREIGN KEY (`idConsomation`) REFERENCES `consomation` (`idConsomation`);

--
-- Contraintes pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `reclamation_ibfk_1` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
