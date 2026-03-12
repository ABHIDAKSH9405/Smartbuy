-- ============================================================================
-- SCHEMA DE LA BASE DE DONNÉES SMARTBUY
-- ============================================================================

-- NOTE IMPORTANTE :
-- Si la table 'produits' existe déjà avec la structure suivante,
-- vous n'avez PAS besoin d'exécuter ce script.
-- Ce fichier est fourni uniquement à titre de référence.

-- Structure de la table produits (déjà existante)
-- Colonnes : id, nom, slug, description, prix, prix_promo, stock,
--            note, nombre_avis, image, en_vedette, nouveaute,
--            categorie_id, marque_id, date_creation, date_modification

-- Si la table produits n'existe pas encore, voici le script pour la créer :

CREATE TABLE IF NOT EXISTS produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    description TEXT,
    prix DECIMAL(10, 2) NOT NULL,
    prix_promo DECIMAL(10, 2) DEFAULT NULL,
    stock INT DEFAULT 0,
    note DECIMAL(3, 2) DEFAULT NULL,
    nombre_avis INT DEFAULT 0,
    image VARCHAR(500) NOT NULL,
    en_vedette TINYINT(1) DEFAULT 0,
    nouveaute TINYINT(1) DEFAULT 0,
    categorie_id INT DEFAULT NULL,
    marque_id INT DEFAULT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_slug (slug),
    INDEX idx_categorie (categorie_id),
    INDEX idx_marque (marque_id),
    INDEX idx_date_creation (date_creation),
    INDEX idx_nouveaute (nouveaute),
    INDEX idx_vedette (en_vedette)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Note: Le système de vente utilise désormais les colonnes existantes de votre table
