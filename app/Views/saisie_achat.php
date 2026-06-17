<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/sidebar.css">
    <link rel="stylesheet" href="/assets/css/saisie_achat.css">
    <title>Saisie des Achats</title>
</head>

<body>

    <!-- ===== SIDEBAR ===== -->
    <?= view('sidebar') ?>

    <!-- ===== CONTENU PRINCIPAL ===== -->
    <div class="main-content">

        <div class="container">

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

            <!-- Menu -->
            <div class="menu">
                <ul>
                    <li><a href="#" class="active">🛒 Saisie des achats</a></li>
                    <li><a href="#">📋 Historique</a></li>
                    <li><a href="#">📊 Statistiques</a></li>
                </ul>
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

                <?php if (!empty($lignes) && count($lignes) > 0): ?>
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
                            foreach ($lignes as $ligne):
                                $sous_total = $ligne->quantite * $ligne->prix_unitaire;
                                $total += $sous_total;
                                ?>
                                <tr>
                                    <td><?= $ligne->designation ?></td>
                                    <td class="text-right">
                                        <?= number_format($ligne->prix_unitaire, 0, ',', ' ') ?> FCFA
                                    </td>
                                    <td class="text-center"><?= $ligne->quantite ?></td>
                                    <td class="text-right">
                                        <?= number_format($sous_total, 0, ',', ' ') ?> FCFA
                                    </td>
                                    <td class="text-center">
                                        <form action="/supprimer-ligne" method="post" style="display:inline;">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id_ligne" value="<?= $ligne->id_ligne ?>">
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
                                <?= number_format($total, 0, ',', ' ') ?> FCFA
                            </div>
                        </div>
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