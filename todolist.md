## todo list du projet supermarche
### base de donne
        [ok]creation des tables
            -produits:
            ``` sql
                CREATE TABLE produits (
                    id_produit INTEGER PRIMARY KEY AUTOINCREMENT,
                    designation TEXT NOT NULL,
                    prix_vente REAL NOT NULL CHECK(prix_vente >= 0),
                    stock INTEGER NOT NULL DEFAULT 0 CHECK(stock >= 0),
                    code_barre TEXT UNIQUE,
                    categorie TEXT
                );
                ```
            -caisses:
                CREATE TABLE caisses (
                    id_caisse INTEGER PRIMARY KEY AUTOINCREMENT,
                    numero INTEGER UNIQUE NOT NULL,
                    caissier TEXT,
                    statut TEXT DEFAULT 'ouverte' CHECK(statut IN ('ouverte', 'fermee'))
                );
            -achat:

            CREATE TABLE achats (
                id_achat INTEGER PRIMARY KEY AUTOINCREMENT,
                id_caisse INTEGER NOT NULL,
                date_achat DATETIME DEFAULT CURRENT_TIMESTAMP,
                total REAL DEFAULT 0,
                statut TEXT DEFAULT 'en_cours' CHECK(statut IN ('en_cours', 'cloture')),
                FOREIGN KEY (id_caisse) REFERENCES caisses(id_caisse)
            );

            -lignes_achat:

            CREATE TABLE lignes_achat (
                id_ligne INTEGER PRIMARY KEY AUTOINCREMENT,
                id_achat INTEGER NOT NULL,
                id_produit INTEGER NOT NULL,
                quantite INTEGER NOT NULL CHECK(quantite > 0),
                prix_unitaire REAL NOT NULL,
                FOREIGN KEY (id_achat) REFERENCES achats(id_achat) ON DELETE CASCADE,
                FOREIGN KEY (id_produit) REFERENCES produits(id_produit)
            );
            -utilisateurs

            CREATE TABLE utilisateurs(
                id_user INTEGER PRIMARY KEY AUTOINCREMENT,
                login TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                nom_complet TEXT,
                role TEXT DEFAULT 'caissier' CHECK(role IN ('admin', 'caissier'))
            );


