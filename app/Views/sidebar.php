<!-- Sidebar -->
<button class="hamburger" onclick="toggleSidebar()">☰</button>

<div class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="logo">
        <h1>🏪 <span>Super</span>Marché</h1>
        <div class="subtitle">CAISSE EN LIGNE</div>
    </div>

    <!-- Informations utilisateur - DYNAMIQUE -->
    <div class="user-info">
        <div class="avatar">
            <?php
            $nom = session()->get('nom_complet') ?? 'Utilisateur';
            $initiales = '';
            $mots = explode(' ', $nom);
            foreach ($mots as $mot) {
                $initiales .= strtoupper(substr($mot, 0, 1));
            }
            echo $initiales ?: 'U';
            ?>
        </div>
        <div class="user-details">
            <div class="name"><?= session()->get('nom_complet') ?? 'Utilisateur' ?></div>
            <div class="role">👤 <?= ucfirst(session()->get('role') ?? 'Caissier') ?></div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="nav-menu">
        <div class="nav-section">Menu Principal</div>
        <ul>
            <li>
                <a href="<?= base_url('/choix-caisse') ?>"
                    class="<?= current_url() == base_url('/choix-caisse') ? 'active' : '' ?>">
                    <span class="icon">🏠</span>
                    <span>Accueil</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('/saisie-achat') ?>"
                    class="<?= strpos(current_url(), 'saisie-achat') !== false ? 'active' : '' ?>">
                    <span class="icon">🛒</span>
                    <span>Saisie des achats</span>
                    <?php if (session()->get('nb_articles')): ?>
                        <span class="badge"><?= session()->get('nb_articles') ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li>
                <a href="<?= base_url('/historique') ?>"
                    class="<?= strpos(current_url(), 'historique') !== false ? 'active' : '' ?>">
                    <span class="icon">📋</span>
                    <span>Historique</span>
                </a>
            </li>
        </ul>

        <div class="nav-section" style="margin-top: 20px;">Gestion</div>
        <ul>
            <li>
                <a href="<?= base_url('/produits') ?>"
                    class="<?= strpos(current_url(), 'produits') !== false ? 'active' : '' ?>">
                    <span class="icon">📦</span>
                    <span>Produits</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('/caisses') ?>"
                    class="<?= strpos(current_url(), 'caisses') !== false ? 'active' : '' ?>">
                    <span class="icon">🏪</span>
                    <span>Caisses</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('/utilisateurs') ?>"
                    class="<?= strpos(current_url(), 'utilisateurs') !== false ? 'active' : '' ?>">
                    <span class="icon">👥</span>
                    <span>Utilisateurs</span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('/statistiques') ?>"
                    class="<?= strpos(current_url(), 'statistiques') !== false ? 'active' : '' ?>">
                    <span class="icon">📊</span>
                    <span>Statistiques</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Footer -->
    <div class="sidebar-footer">
        <a href="<?= base_url('/auth/logout') ?>" class="logout-btn">
            <span class="icon">🚪</span>
            <span>Déconnexion</span>
        </a>
    </div>
</div>

<!-- JavaScript pour mobile -->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('open');
    }

    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('sidebar');
        const hamburger = document.querySelector('.hamburger');
        if (hamburger && sidebar) {
            const isClickInside = sidebar.contains(event.target) || hamburger.contains(event.target);
            if (!isClickInside && window.innerWidth <= 576) {
                sidebar.classList.remove('open');
            }
        }
    });
</script>