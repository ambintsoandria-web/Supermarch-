-- ============================================
-- BASE DE DONNÉES : caisse_supermarche.db
-- PROJET : TD SI-IHM - CODEIGNITER
-- ============================================

-- ============================================
-- 1. TABLE PRODUITS
-- ============================================
CREATE TABLE produits (
    id_produit INTEGER PRIMARY KEY AUTOINCREMENT,
    designation TEXT NOT NULL,
    prix_vente REAL NOT NULL CHECK(prix_vente >= 0),
    stock INTEGER NOT NULL DEFAULT 0 CHECK(stock >= 0),
    code_barre TEXT UNIQUE,
    categorie TEXT
);

-- ============================================
-- 2. TABLE CAISSES
-- ============================================
CREATE TABLE caisses (
    id_caisse INTEGER PRIMARY KEY AUTOINCREMENT,
    numero INTEGER UNIQUE NOT NULL,
    caissier TEXT,
    statut TEXT DEFAULT 'ouverte' CHECK(statut IN ('ouverte', 'fermee'))
);

-- ============================================
-- 3. TABLE ACHATS (un achat = un client / un panier)
-- ============================================
CREATE TABLE achats (
    id_achat INTEGER PRIMARY KEY AUTOINCREMENT,
    id_caisse INTEGER NOT NULL,
    date_achat DATETIME DEFAULT CURRENT_TIMESTAMP,
    total REAL DEFAULT 0,
    statut TEXT DEFAULT 'en_cours' CHECK(statut IN ('en_cours', 'cloture')),
    FOREIGN KEY (id_caisse) REFERENCES caisses(id_caisse)
);

-- ============================================
-- 4. TABLE LIGNES_ACHAT (détail des produits achetés)
-- ============================================
CREATE TABLE lignes_achat (
    id_ligne INTEGER PRIMARY KEY AUTOINCREMENT,
    id_achat INTEGER NOT NULL,
    id_produit INTEGER NOT NULL,
    quantite INTEGER NOT NULL CHECK(quantite > 0),
    prix_unitaire REAL NOT NULL,
    FOREIGN KEY (id_achat) REFERENCES achats(id_achat) ON DELETE CASCADE,
    FOREIGN KEY (id_produit) REFERENCES produits(id_produit)
);

-- ============================================
-- 5. TABLE UTILISATEURS (pour login)
-- ============================================
CREATE TABLE utilisateurs (
    id_user INTEGER PRIMARY KEY AUTOINCREMENT,
    login TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    nom_complet TEXT,
    role TEXT DEFAULT 'caissier' CHECK(role IN ('admin', 'caissier'))
);

-- ============================================
-- DONNÉES INITIALES
-- ============================================

-- 5 PRODUITS
INSERT INTO produits (designation, prix_vente, stock, code_barre, categorie) VALUES
('Lait 1L', 1.20, 50, 'LAIT001', 'Alimentaire'),
('Pain de mie 500g', 2.50, 30, 'PAIN001', 'Boulangerie'),
('Pâtes spaghetti 500g', 1.80, 100, 'PATE001', 'Alimentaire'),
('Coca-Cola 1.5L', 2.90, 40, 'COCA001', 'Boisson'),
('Savon doux', 3.50, 25, 'SAVON001', 'Hygiène');

-- 2 CAISSES
INSERT INTO caisses (numero, caissier, statut) VALUES
(1, 'Jean Dupont', 'ouverte'),
(2, 'Marie Martin', 'ouverte');

-- 2 UTILISATEURS (mot de passe : admin123 / caisse123)
INSERT INTO utilisateurs (login, password, nom_complet, role) VALUES
('admin', 'admin123', 'Administrateur', 'admin'),
('caissier', 'caisse123', 'Jean Dupont', 'caissier');