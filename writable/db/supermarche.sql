CREATE TABLE produits (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    designation TEXT,
    prix REAL,
    stock INTEGER
);

CREATE TABLE caisses (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero INTEGER UNIQUE
);

CREATE TABLE achats (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_caisse INTEGER,
    id_produit INTEGER,
    quantite INTEGER,
    date_achat DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_caisse) REFERENCES caisses(id),
    FOREIGN KEY (id_produit) REFERENCES produits(id)
);

INSERT INTO produits (designation, prix, stock) VALUES
('Lait', 1.20, 50),
('Pain', 2.50, 30),
('Pâtes', 1.80, 100),
('Coca', 2.90, 40),
('Savon', 3.50, 25);

INSERT INTO caisses (numero) VALUES (1), (2);