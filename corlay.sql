-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 07 mai 2024 à 16:27
-- Version du serveur : 8.0.36-0ubuntu0.22.04.1
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `corlay`
--

-- --------------------------------------------------------

--
-- Structure de la table `albums`
--

CREATE TABLE `albums` (
  `id` int NOT NULL,
  `nomalbum` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `miniature` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrephotos` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `title`, `date`, `content`, `image`, `preview`) VALUES
(1, 'Colline verdoyante', '2024-05-02 14:30:40', '<p>Dans le doux écrin de la nature, une colline verdoyante s\'érige majestueusement, offrant un spectacle apaisant à ceux qui ont le privilège de contempler sa beauté. Nichée au cœur d\'un paysage luxuriant, elle se dresse comme un gardien silencieux, veillant sur la splendeur qui l\'entoure.</p><p>Au sommet de cette colline, l\'herbe ondule doucement sous la caresse du vent, créant des vagues d\'émeraude qui dansent au gré des éléments. Des arbres majestueux, aux feuilles chatoyantes, s\'élèvent fièrement, offrant ombre et refuge aux visiteurs émerveillés. Leurs branches s\'entremêlent dans un ballet harmonieux, formant un dôme naturel où les rayons du soleil filtrent délicatement, peignant le sol d\'une lumière dorée.</p><p>À chaque pas gravissant cette colline, l\'air devient plus pur, plus vivifiant. Le chant des oiseaux accompagne le voyageur, lui offrant une symphonie naturelle, tandis que le parfum enivrant des fleurs sauvages chatouille ses sens.</p><p>De ce point culminant, le regard embrasse un panorama à couper le souffle. Les vallées verdoyantes s\'étendent à perte de vue, parsemées de rivières serpentines scintillantes sous les rayons du soleil. Les montagnes lointaines se découpent sur l\'horizon, leur silhouette majestueuse se perdant dans les nuages.</p><p>Mais la véritable magie de cette colline verdoyante réside dans sa capacité à offrir un refuge spirituel, un havre de paix où l\'âme peut se ressourcer. Que ce soit pour méditer, contempler le coucher du soleil ou simplement s\'imprégner de la sérénité qui règne en ces lieux, chaque visiteur repart avec le cœur empli de quiétude et l\'esprit rafraîchi.</p><p>Ainsi, la colline verdoyante demeure bien plus qu\'un simple accident géographique ; elle incarne la quintessence de la beauté naturelle, un joyau de verdure qui invite chacun à se reconnecter avec la splendeur du monde qui nous entoure.</p>', '2147e248c229645f25ae7bc443b80623.png', 'Colline verdoyante');

-- --------------------------------------------------------

--
-- Structure de la table `boutique`
--

CREATE TABLE `boutique` (
  `id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emplacement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ouverture` time NOT NULL,
  `fermeture` time NOT NULL,
  `contacts` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `carousel`
--

CREATE TABLE `carousel` (
  `id` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `couts`
--

CREATE TABLE `couts` (
  `id` int NOT NULL,
  `super` double DEFAULT NULL,
  `gasoil` double DEFAULT NULL,
  `petrole` double DEFAULT NULL,
  `ddo` double DEFAULT NULL,
  `ddoad` double DEFAULT NULL,
  `butane` double DEFAULT NULL,
  `btc` double DEFAULT NULL,
  `bt6kg` double DEFAULT NULL,
  `bt12kg` double DEFAULT NULL,
  `fuel` double DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `annee` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `declinaisons`
--

CREATE TABLE `declinaisons` (
  `id` int NOT NULL,
  `fk_lubrifiant_id` int NOT NULL,
  `nom` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `performance` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emballage` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fichetechnique` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apercu` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240502114722', '2024-05-02 11:47:31', 242);

-- --------------------------------------------------------

--
-- Structure de la table `lubrifiants`
--

CREATE TABLE `lubrifiants` (
  `id` int NOT NULL,
  `lub_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lub_description` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mails`
--

CREATE TABLE `mails` (
  `id` int NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sujet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `partners`
--

CREATE TABLE `partners` (
  `id` int NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `partners`
--

INSERT INTO `partners` (`id`, `libelle`, `image`) VALUES
(1, 'Confort Zone', '716b903e777d5bd154c70f42451b47da.png'),
(2, 'The GearHead', '17d0f509b14b29458e8f39cfb8e3aab9.png'),
(3, 'Style', '5ec7f494613bbfbe8561e9c67f728219.png'),
(4, 'Organic', '5712176d1b9803dd77f726d6f646d8a8.png'),
(5, 'Cupcake', 'faf220efab1cd08eabc7aa7b8a5b8b0e.png');

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE `photos` (
  `id` int NOT NULL,
  `fk_albums_id` int NOT NULL,
  `imagename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stations`
--

CREATE TABLE `stations` (
  `id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emplacement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `framecode` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt6` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bt12` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lubs` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cshop` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contacts` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tlogin`
--

CREATE TABLE `tlogin` (
  `id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prenoms` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tlogin`
--

INSERT INTO `tlogin` (`id`, `email`, `roles`, `password`, `nom`, `prenoms`) VALUES
(1, 'a@b.com', '[]', '$2y$13$N51l5sJDnTx9SbkKbiYIQ.80I5fMT4YUD14JB2wXP9Yqsyogvjy/2', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `videos`
--

CREATE TABLE `videos` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `thumb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `boutique`
--
ALTER TABLE `boutique`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `couts`
--
ALTER TABLE `couts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `declinaisons`
--
ALTER TABLE `declinaisons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BA51C68AD9077592` (`fk_lubrifiant_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `lubrifiants`
--
ALTER TABLE `lubrifiants`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_876E0D98DE2823F` (`fk_albums_id`);

--
-- Index pour la table `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tlogin`
--
ALTER TABLE `tlogin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4D5BD279E7927C74` (`email`);

--
-- Index pour la table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `boutique`
--
ALTER TABLE `boutique`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `couts`
--
ALTER TABLE `couts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `declinaisons`
--
ALTER TABLE `declinaisons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `lubrifiants`
--
ALTER TABLE `lubrifiants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mails`
--
ALTER TABLE `mails`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stations`
--
ALTER TABLE `stations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tlogin`
--
ALTER TABLE `tlogin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `declinaisons`
--
ALTER TABLE `declinaisons`
  ADD CONSTRAINT `FK_BA51C68AD9077592` FOREIGN KEY (`fk_lubrifiant_id`) REFERENCES `lubrifiants` (`id`);

--
-- Contraintes pour la table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `FK_876E0D98DE2823F` FOREIGN KEY (`fk_albums_id`) REFERENCES `albums` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
