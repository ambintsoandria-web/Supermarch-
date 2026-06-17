<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/sidebar.css">
    <link rel="stylesheet" href="/assets/css/hist1.css">
    <title>Détail de l'achat</title>
    <style>
    </style>
</head>

<body>

    <?= view('sidebar') ?>

    <div class="main-content">
        <div class="container">

            <div class="header">
                <div class="caisse-info">
                    🏪 Caisse n° <?= $caisse->numero ?? 'Non définie' ?>
                    <?php if (!empty($caisse->caissier)): ?>
                        <span>| 👤 <?= $caisse->caissier ?></span>
                    <?php endif; ?>
                </div>
                <div>
                    <a href="/" class="btn-changer">⬅ Changer de caisse</a>
                </div>
            </div>

            <div class="menu">
                <ul>
                    <li><a href="/saisie-achat">🛒 Saisie des achats</a></li>
                    <li><a href="/historique" class="active">📋 Historique</a></li>
                </ul>
            </div>

            <div class="info-achat">
                <div>
                    <h2 style="margin: 0;">📋 Achat #<?= $achat->id_achat ?></h2>
                    <span style="color: #888;">📅 <?= date('d/m/Y H:i', strtotime($achat->date_achat)) ?></span>
                </div>
                <div>
                    <span class="total-achat">
                        <?= number_format($achat->total, 0, ',', ' ') ?> AR
                    </span>
                </div>
            </div>

            <h2>🛒 Détail de l'achat</h2>

            <?php if (!empty($lignes) && count($lignes) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th class="text-right">Prix Unit.</th>
                            <th class="text-center">Qté</th>
                            <th class="text-right">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lignes as $ligne):
                            $sous_total = $ligne->quantite * $ligne->prix_unitaire;
                            ?>
                            <tr>
                                <td><?= $ligne->designation ?></td>
                                <td class="text-right">
                                    <?= number_format($ligne->prix_unitaire, 0, ',', ' ') ?> AR
                                </td>
                                <td class="text-center"><?= $ligne->quantite ?></td>
                                <td class="text-right">
                                    <?= number_format($sous_total, 0, ',', ' ') ?> AR
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div style="text-align: right;">
                    <a href="/historique" class="btn-retour">⬅ Retour</a>
                </div>

            <?php else: ?>
                <div class="empty">
                    <p>Aucun produit dans cet achat</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

</body>

</html>