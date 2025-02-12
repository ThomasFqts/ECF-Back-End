-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 12 fév. 2025 à 16:47
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
-- Base de données : `afpa_wazaa_immo`
--
CREATE DATABASE IF NOT EXISTS `afpa_wazaa_immo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `afpa_wazaa_immo`;

-- --------------------------------------------------------

--
-- Structure de la table `waz_annonces`
--

DROP TABLE IF EXISTS `waz_annonces`;
CREATE TABLE `waz_annonces` (
  `an_id` int(11) NOT NULL,
  `an_numero` int(11) DEFAULT NULL,
  `an_pieces` int(11) DEFAULT NULL,
  `an_vue` int(11) NOT NULL,
  `an_ref` varchar(10) NOT NULL,
  `an_titre` varchar(200) NOT NULL,
  `an_description` varchar(100) NOT NULL,
  `an_local` varchar(100) NOT NULL,
  `an_surf_hab` int(11) DEFAULT NULL,
  `an_surf_tot` int(11) NOT NULL,
  `an_prix` int(11) NOT NULL,
  `an_diagnostic` varchar(1) NOT NULL,
  `an_d_ajout` date NOT NULL,
  `an_d_modif` date DEFAULT NULL,
  `an_etat` tinyint(1) NOT NULL,
  `ut_id` int(11) NOT NULL,
  `tp_bn_id` int(11) DEFAULT NULL,
  `tp_ofr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_annonces`
--

INSERT INTO `waz_annonces` (`an_id`, `an_numero`, `an_pieces`, `an_vue`, `an_ref`, `an_titre`, `an_description`, `an_local`, `an_surf_hab`, `an_surf_tot`, `an_prix`, `an_diagnostic`, `an_d_ajout`, `an_d_modif`, `an_etat`, `ut_id`, `tp_bn_id`, `tp_ofr_id`) VALUES
(1, NULL, 5, 0, '20A100', '100 km de Paris, Appartement 85m2 avec jardin', 'Exclusivité : dans bourg tous commerces avec écoles, maison d\'environ 85m2 habitables, mitoyenne, of', '1h00 de Paris', 85, 225, 197000, 'F', '2020-11-13', NULL, 1, 1, NULL, 1),
(2, NULL, 3, 0, '40C015', '25 km de Bordeau, Appartement 55m2', 'Tous commerces avec écoles à - de 1km, appartement d\'environ 55m2 habitables, une cuisine aménagée, ', '2h30 de Toulouse', 55, 70, 100000, 'F', '2020-11-13', NULL, 1, 1, NULL, 2);

-- --------------------------------------------------------

--
-- Structure de la table `waz_an_opt`
--

DROP TABLE IF EXISTS `waz_an_opt`;
CREATE TABLE `waz_an_opt` (
  `an_id` int(11) NOT NULL,
  `opt_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_an_opt`
--

INSERT INTO `waz_an_opt` (`an_id`, `opt_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `waz_options`
--

DROP TABLE IF EXISTS `waz_options`;
CREATE TABLE `waz_options` (
  `opt_id` int(11) NOT NULL,
  `opt_libelle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_options`
--

INSERT INTO `waz_options` (`opt_id`, `opt_libelle`) VALUES
(1, 'Jardin'),
(2, 'Garage'),
(3, 'Parking'),
(4, 'Piscine'),
(5, 'Combles aménageables'),
(6, 'Cuisine ouverte'),
(7, 'Sans travaux'),
(8, 'Avec travaux'),
(9, 'Cave'),
(10, 'Plain-pied'),
(11, 'Ascenseur'),
(12, 'Terrasse/balcon'),
(13, 'Cheminée');

-- --------------------------------------------------------

--
-- Structure de la table `waz_photo`
--

DROP TABLE IF EXISTS `waz_photo`;
CREATE TABLE `waz_photo` (
  `ft_id` int(11) NOT NULL,
  `ft_nom` varchar(50) NOT NULL,
  `an_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_photo`
--

INSERT INTO `waz_photo` (`ft_id`, `ft_nom`, `an_id`) VALUES
(1, 'annonce_1/1-1', 1),
(2, 'annonce_1/1-2', 1),
(3, 'annonce_2/2-1', 2),
(4, 'annonce_2/2-2', 2);

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_bien`
--

DROP TABLE IF EXISTS `waz_type_bien`;
CREATE TABLE `waz_type_bien` (
  `tp_bn_id` int(11) NOT NULL,
  `tp_bn_libelle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_type_bien`
--

INSERT INTO `waz_type_bien` (`tp_bn_id`, `tp_bn_libelle`) VALUES
(1, 'Maison'),
(2, 'Appartement'),
(3, 'Immeuble'),
(4, 'Garage'),
(5, 'Terrain'),
(6, 'Locaux professionnels'),
(7, 'Bureaux');

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_offre`
--

DROP TABLE IF EXISTS `waz_type_offre`;
CREATE TABLE `waz_type_offre` (
  `tp_ofr_id` int(11) NOT NULL,
  `tp_ofr_libelle` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_type_offre`
--

INSERT INTO `waz_type_offre` (`tp_ofr_id`, `tp_ofr_libelle`) VALUES
(1, 'A'),
(2, 'L'),
(3, 'V');

-- --------------------------------------------------------

--
-- Structure de la table `waz_type_utilisateur`
--

DROP TABLE IF EXISTS `waz_type_utilisateur`;
CREATE TABLE `waz_type_utilisateur` (
  `tp_ut_id` int(11) NOT NULL,
  `tp_ut_libelle` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_type_utilisateur`
--

INSERT INTO `waz_type_utilisateur` (`tp_ut_id`, `tp_ut_libelle`) VALUES
(1, 'Admin'),
(2, 'Visiteur');

-- --------------------------------------------------------

--
-- Structure de la table `waz_utilisateurs`
--

DROP TABLE IF EXISTS `waz_utilisateurs`;
CREATE TABLE `waz_utilisateurs` (
  `ut_id` int(11) NOT NULL,
  `ut_email` varchar(100) NOT NULL,
  `ut_mdp` varchar(500) NOT NULL,
  `tp_ut_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `waz_utilisateurs`
--

INSERT INTO `waz_utilisateurs` (`ut_id`, `ut_email`, `ut_mdp`, `tp_ut_id`) VALUES
(1, 'john.wick@test.com', '$2y$12$TBwhz59iX7LdWqKB.q94EOF5b8eBWSPAHNEJ6AG/jmg1k.4LyBlGa', 1),
(2, 'clara.balade@test.com', '$2y$12$TBwhz59iX7LdWqKB.q94EOF5b8eBWSPAHNEJ6AG/jmg1k.4LyBlGa', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `waz_annonces`
--
ALTER TABLE `waz_annonces`
  ADD PRIMARY KEY (`an_id`),
  ADD KEY `ut_id` (`ut_id`),
  ADD KEY `tp_bn_id` (`tp_bn_id`),
  ADD KEY `tp_ofr_id` (`tp_ofr_id`);

--
-- Index pour la table `waz_an_opt`
--
ALTER TABLE `waz_an_opt`
  ADD PRIMARY KEY (`an_id`,`opt_id`),
  ADD KEY `opt_id` (`opt_id`);

--
-- Index pour la table `waz_options`
--
ALTER TABLE `waz_options`
  ADD PRIMARY KEY (`opt_id`);

--
-- Index pour la table `waz_photo`
--
ALTER TABLE `waz_photo`
  ADD PRIMARY KEY (`ft_id`),
  ADD KEY `an_id` (`an_id`);

--
-- Index pour la table `waz_type_bien`
--
ALTER TABLE `waz_type_bien`
  ADD PRIMARY KEY (`tp_bn_id`);

--
-- Index pour la table `waz_type_offre`
--
ALTER TABLE `waz_type_offre`
  ADD PRIMARY KEY (`tp_ofr_id`);

--
-- Index pour la table `waz_type_utilisateur`
--
ALTER TABLE `waz_type_utilisateur`
  ADD PRIMARY KEY (`tp_ut_id`);

--
-- Index pour la table `waz_utilisateurs`
--
ALTER TABLE `waz_utilisateurs`
  ADD PRIMARY KEY (`ut_id`),
  ADD KEY `tp_ut_id` (`tp_ut_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `waz_annonces`
--
ALTER TABLE `waz_annonces`
  MODIFY `an_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `waz_options`
--
ALTER TABLE `waz_options`
  MODIFY `opt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `waz_photo`
--
ALTER TABLE `waz_photo`
  MODIFY `ft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `waz_type_bien`
--
ALTER TABLE `waz_type_bien`
  MODIFY `tp_bn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `waz_type_offre`
--
ALTER TABLE `waz_type_offre`
  MODIFY `tp_ofr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `waz_type_utilisateur`
--
ALTER TABLE `waz_type_utilisateur`
  MODIFY `tp_ut_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `waz_utilisateurs`
--
ALTER TABLE `waz_utilisateurs`
  MODIFY `ut_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `waz_annonces`
--
ALTER TABLE `waz_annonces`
  ADD CONSTRAINT `waz_annonces_ibfk_1` FOREIGN KEY (`ut_id`) REFERENCES `waz_utilisateurs` (`ut_id`),
  ADD CONSTRAINT `waz_annonces_ibfk_2` FOREIGN KEY (`tp_bn_id`) REFERENCES `waz_type_bien` (`tp_bn_id`),
  ADD CONSTRAINT `waz_annonces_ibfk_3` FOREIGN KEY (`tp_ofr_id`) REFERENCES `waz_type_offre` (`tp_ofr_id`);

--
-- Contraintes pour la table `waz_an_opt`
--
ALTER TABLE `waz_an_opt`
  ADD CONSTRAINT `waz_an_opt_ibfk_1` FOREIGN KEY (`an_id`) REFERENCES `waz_annonces` (`an_id`),
  ADD CONSTRAINT `waz_an_opt_ibfk_2` FOREIGN KEY (`opt_id`) REFERENCES `waz_options` (`opt_id`);

--
-- Contraintes pour la table `waz_photo`
--
ALTER TABLE `waz_photo`
  ADD CONSTRAINT `waz_photo_ibfk_1` FOREIGN KEY (`an_id`) REFERENCES `waz_annonces` (`an_id`);

--
-- Contraintes pour la table `waz_utilisateurs`
--
ALTER TABLE `waz_utilisateurs`
  ADD CONSTRAINT `waz_utilisateurs_ibfk_1` FOREIGN KEY (`tp_ut_id`) REFERENCES `waz_type_utilisateur` (`tp_ut_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
