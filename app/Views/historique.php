<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/sidebar.css">
    <link rel="stylesheet" href="/assets/css/hist.css">
    <title>Historique des Achats</title>
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
                    <li><a href="#" class="active">📋 Historique</a></li>
                </ul>
            </div>

            <h2>📋 Historique des achats</h2>

            <?php if (!empty($achats) && count($achats) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th class="text-right">Total</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($achats as $achat): ?>
                            <tr>
                                <td><strong>#<?= $achat->id_achat ?></strong></td>
                                <td><?= date('d/m/Y H:i', strtotime($achat->date_achat)) ?></td>
                                <td class="text-right">
                                    <span class="total-box">
                                        <?= number_format($achat->total, 0, ',', ' ') ?> AR
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="/historique/detail/<?= $achat->id_achat ?>" class="btn-detail">
                                        👁️ Voir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty">
                    <div class="icon">📭</div>
                    <p>Aucun achat effectué</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

</body>

</html>