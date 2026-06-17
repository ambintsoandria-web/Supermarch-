<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/sidebar.css">
    <link rel="stylesheet" href="/assets/css/saisie_achat.css">
    <title>Saisie des Achats</title>
    <style>
        .btn-valider-achat {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 20px;
            width: 100%;
        }

        .btn-valider-achat:hover {
            background: #45a049;
        }

        .btn-valider-achat:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-vider {
            background: #f44336;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-vider:hover {
            background: #d32f2f;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #28a745;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #dc3545;
        }
    </style>
</head>

<body>

    <!-- ===== SIDEBAR ===== -->
    <?= view('sidebar') ?>

    <!-- ===== CONTENU PRINCIPAL ===== -->
    <div class="main-content">

        <div class="container">

            <!-- Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="success">✅ <?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="error">❌ <?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <!-- En-tête avec la caisse -->
            <div class="header">
                <div class="caisse-info">
                    🏪 Caisse n°
                    <?= $caisse->numero ?? 'Non définie' ?>
                    <?php if (!empty($caisse->caissier)): ?>
                        <span>| 👤
                            <?= $caisse->caissier ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div>
                    <a href="/" class="btn-changer">⬅ Changer de caisse</a>
                </div>
            </div>

            <!-- Formulaire d'ajout -->
            <div class="form-section">
                <h2>📦 Ajouter un produit</h2>
                <form action="/ajouter-produit" method="post" class="form-row">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="id_produit">Produit</label>
                        <select name="id_produit" id="id_produit" required>
                            <option value="">-- Choisir un produit --</option>
                            <?php if (!empty($produits)): ?>
                                <?php foreach ($produits as $produit): ?>
                                    <option value="<?= $produit->id_produit ?>">
                                        <?= $produit->designation ?>
                                        (
                                        <?= number_format($produit->prix_vente, 2, ',', ' ') ?> AR)
                                        - Stock:
                                        <?= $produit->stock ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quantite">Quantité</label>
                        <input type="number" name="quantite" id="quantite" value="1" min="1" required>
                    </div>

                    <button type="submit" class="btn-ajouter">➕ Ajouter</button>
                </form>
            </div>

            <!-- Tableau du panier -->
            <div class="table-section">
                <h2>🛒 Panier en cours</h2>

                <?php if (!empty($panier) && count($panier) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th class="text-right">Prix Unit.</th>
                                <th class="text-center">Qté</th>
                                <th class="text-right">Montant</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($panier as $index => $item):
                                $sous_total = $item['quantite'] * $item['prix_unitaire'];
                                $total += $sous_total;
                            ?>
                                <tr>
                                    <td><?= $item['designation'] ?></td>
                                    <td class="text-right">
                                        <?= number_format($item['prix_unitaire'], 0, ',', ' ') ?> AR
                                    </td>
                                    <td class="text-center"><?= $item['quantite'] ?></td>
                                    <td class="text-right">
                                        <?= number_format($sous_total, 0, ',', ' ') ?> AR
                                    </td>
                                    <td class="text-center">
                                        <form action="/supprimer-ligne" method="post" style="display:inline;">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="index" value="<?= $index ?>">
                                            <button type="submit" class="btn-supprimer"
                                                onclick="return confirm('Supprimer cette ligne ?')">✕</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="total-section">
                        <div class="total-box">
                            <div class="label">TOTAL</div>
                            <div class="amount">
                                <?= number_format($total, 0, ',', ' ') ?> AR
                            </div>
                        </div>
                    </div>

                    <!-- Boutons Valider et Vider -->
                    <div class="actions">
                        <form action="/valider-achat" method="post" style="flex:1;">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn-valider-achat">
                                ✅ Valider l'achat
                            </button>
                        </form>
                        <form action="/vider-panier" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn-vider" onclick="return confirm('Vider le panier ?')">
                                🗑️ Vider
                            </button>
                        </form>
                    </div>

                <?php else: ?>
                    <div class="empty-cart">
                        <div class="icon">🛒</div>
                        <p>Le panier est vide</p>
                        <p style="font-size: 14px; color: #bbb;">Ajoutez des produits ci-dessus</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>

    </div>

</body>
</html>