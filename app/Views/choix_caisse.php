<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/choix_caisse.css">
    <title>Choix de la Caisse</title>
    <style>
    </style>
</head>

<body>
    <div class="container">
        <h1>🏪 Supermarché</h1>
        <p class="sous-titre">Choisissez votre caisse</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="error">
                ❌ <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="/valider-caisse" method="post" id="formCaisse">
            <?= csrf_field() ?>

            <?php if (!empty($listeCaisse) && count($listeCaisse) > 0): ?>
                <?php foreach ($listeCaisse as $caisse): ?>
                    <div class="caisse-option"
                        onclick="document.getElementById('caisse_<?= $caisse->id_caisse ?>').checked = true; verifierSelection();">
                        <input type="radio" name="id_caisse" value="<?= $caisse->id_caisse ?>"
                            id="caisse_<?= $caisse->id_caisse ?>" onchange="verifierSelection()">
                        <label for="caisse_<?= $caisse->id_caisse ?>">
                            🏷️ Caisse n°<?= $caisse->numero ?>
                        </label>
                        <?php if (!empty($caisse->caissier)): ?>
                            <div class="caissier-info">
                                👤 <?= $caisse->caissier ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <button type="submit" class="btn-valider" id="btnValider" disabled>
                    ✅ Valider
                </button>

            <?php else: ?>
                <div class="aucune-caisse">
                    <div class="icon">🚫</div>
                    <p>Aucune caisse ouverte disponible</p>
                    <p style="font-size: 12px; margin-top: 5px; color: #bbb;">Veuillez contacter l'administrateur</p>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <script>
        function verifierSelection() {
            const radios = document.querySelectorAll('input[name="id_caisse"]');
            const btnValider = document.getElementById('btnValider');
            let checked = false;
            radios.forEach(radio => {
                if (radio.checked) {
                    checked = true;
                }
            });
            btnValider.disabled = !checked;
        }
    </script>
</body>

</html>