-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 17 avr. 2024 à 19:10
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `attt`
--

-- --------------------------------------------------------

--
-- Structure de la table `centre_technique`
--

CREATE TABLE `centre_technique` (
  `code_centre` int(11) NOT NULL,
  `type` enum('VT','EX') NOT NULL,
  `gouvernorat` varchar(200) NOT NULL,
  `nom_centre` varchar(200) NOT NULL,
  `adresse_centre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `centre_technique`
--

INSERT INTO `centre_technique` (`code_centre`, `type`, `gouvernorat`, `nom_centre`, `adresse_centre`) VALUES
(2007, 'VT', 'Ben Arous', 'Centre d\'identification de Ben Arous', 'Rue la monnaie - Zone industrielle Ben Arous 2013');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `ncin` varchar(8) NOT NULL,
  `nom` varchar(200) NOT NULL,
  `prenom` varchar(200) NOT NULL,
  `date_de_naissance` date NOT NULL,
  `genre` enum('M','F') NOT NULL,
  `adresse` text NOT NULL,
  `num_tel` varchar(8) NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mot_de_passe` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `ncin`, `nom`, `prenom`, `date_de_naissance`, `genre`, `adresse`, `num_tel`, `username`, `email`, `mot_de_passe`) VALUES
(1, '73819273', 'Ali', 'Ali', '2000-10-10', 'M', 'Tunis', '20202020', 'ali100', 'ali@gmail.com', '0000'),
(5, '12345678', 'Ali', 'Ali', '2000-10-10', 'M', 'Tunis', '20202020', 'ali120', 'ali@gmail.com', '0000');

-- --------------------------------------------------------

--
-- Structure de la table `disponibilite`
--

CREATE TABLE `disponibilite` (
  `id_centre` int(11) NOT NULL,
  `date` date NOT NULL,
  `nbr_places_dispo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `disponibilite`
--

INSERT INTO `disponibilite` (`id_centre`, `date`, `nbr_places_dispo`) VALUES
(2007, '2024-04-03', 121);

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `id_employe` int(11) NOT NULL,
  `ncin` varchar(8) NOT NULL,
  `nom` varchar(200) NOT NULL,
  `prenom` varchar(200) NOT NULL,
  `date_de_naissance` date NOT NULL,
  `adresse` text NOT NULL,
  `num_tel` varchar(8) NOT NULL,
  `date_embauche` date NOT NULL,
  `salaire` decimal(10,0) NOT NULL,
  `fonction` varchar(50) NOT NULL,
  `privilege` enum('A','D','E') NOT NULL,
  `username` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mot_de_passe` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `id_notif` int(11) NOT NULL,
  `objet` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `date` date NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_employe` int(11) NOT NULL,
  `status` enum('A','B','C') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

CREATE TABLE `rdv` (
  `id_RDV` int(11) NOT NULL,
  `date_RDV` date NOT NULL,
  `type_RDV` enum('VT','P','EX') NOT NULL,
  `methode_de_paiement` varchar(200) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_centre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `resultat_visite_technique`
--

CREATE TABLE `resultat_visite_technique` (
  `id_visite` int(11) NOT NULL,
  `date_visite` date NOT NULL,
  `resultat_visite` varchar(200) NOT NULL,
  `commentaire` text NOT NULL,
  `id_employe` int(11) NOT NULL,
  `num_immatriculation` varchar(100) NOT NULL,
  `id_centre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

CREATE TABLE `vehicule` (
  `num_immatriculation` varchar(100) NOT NULL,
  `marque` varchar(200) NOT NULL,
  `type` enum('V','M','C') NOT NULL,
  `nbr_places` int(11) NOT NULL,
  `id_client` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `centre_technique`
--
ALTER TABLE `centre_technique`
  ADD PRIMARY KEY (`code_centre`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`),
  ADD UNIQUE KEY `ncin` (`ncin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Index pour la table `disponibilite`
--
ALTER TABLE `disponibilite`
  ADD PRIMARY KEY (`id_centre`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`id_employe`),
  ADD UNIQUE KEY `ncin` (`ncin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id_notif`),
  ADD KEY `fk_notification_client` (`id_client`),
  ADD KEY `fk_notification_employe` (`id_employe`);

--
-- Index pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD PRIMARY KEY (`id_RDV`),
  ADD KEY `fk_rdv_centre` (`id_centre`);

--
-- Index pour la table `resultat_visite_technique`
--
ALTER TABLE `resultat_visite_technique`
  ADD PRIMARY KEY (`id_visite`),
  ADD KEY `fk_resultat_visite_technique_employe` (`id_employe`),
  ADD KEY `fk_resultat_visite_technique_centre` (`id_centre`),
  ADD KEY `fk_resultat_visite_technique_vehicule` (`num_immatriculation`);

--
-- Index pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`num_immatriculation`),
  ADD KEY `fk_client_vehicule` (`id_client`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `id_employe` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `id_notif` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `rdv`
--
ALTER TABLE `rdv`
  MODIFY `id_RDV` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `resultat_visite_technique`
--
ALTER TABLE `resultat_visite_technique`
  MODIFY `id_visite` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `disponibilite`
--
ALTER TABLE `disponibilite`
  ADD CONSTRAINT `fk_disponibilite_centre_technique` FOREIGN KEY (`id_centre`) REFERENCES `centre_technique` (`code_centre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `fk_notification_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_notification_employe` FOREIGN KEY (`id_employe`) REFERENCES `employe` (`id_employe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD CONSTRAINT `fk_rdv_centre` FOREIGN KEY (`id_centre`) REFERENCES `centre_technique` (`code_centre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rdv_client` FOREIGN KEY (`id_centre`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `resultat_visite_technique`
--
ALTER TABLE `resultat_visite_technique`
  ADD CONSTRAINT `fk_resultat_visite_technique_centre` FOREIGN KEY (`id_centre`) REFERENCES `centre_technique` (`code_centre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_resultat_visite_technique_employe` FOREIGN KEY (`id_employe`) REFERENCES `employe` (`id_employe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_resultat_visite_technique_vehicule` FOREIGN KEY (`num_immatriculation`) REFERENCES `vehicule` (`num_immatriculation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD CONSTRAINT `fk_client_vehicule` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
