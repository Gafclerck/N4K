<?php
// sidebar.php doi avoir $page (le nom de la page courante), $myGroups (la lsite de ses groupes)
use App\Config\Session;

$navItems = [
    ["page" => "index",    "label" => "Accueil",         "icon" => "fa-home"],
    ["page" => "groupes",  "label" => "Groupes",         "icon" => "fa-users"],
    ["page" => "favoris",  "label" => "Mes Favoris",    "icon" => "fa-bookmark"],
    ["page" => "mes-ressources", "label" => "Mes publications", "icon" => "fa-university"],
];

?>
<aside class="flex flex-col h-full bg-sidebar flex-shrink-0" style="width:240px;border-right:1px solid var(--color-sidebar-border);">
    <!-- Logo -->
    <div class="px-5 py-5 flex items-center gap-2 flex-shrink-0" style="border-bottom:1px solid var(--color-sidebar-border);">
        <span class="font-bold tracking-tight text-white font-lato" style="font-size:22px;">N4K</span>
        <span style="font-size:11px;color:rgba(255,255,255,0.45);">Network For Knowledge</span>
    </div>

    <!-- Navigation (fixe) -->
    <div class="flex-shrink-0 px-3 py-4">
        <div class="mb-6">
            <p class="px-2 mb-1 font-semibold uppercase tracking-wider" style="font-size:11px;color:rgba(255,255,255,0.45);">Navigation</p>
            <nav class="space-y-0.5">
                <?php foreach ($navItems as $item):
                    $isActive = ($page === $item["page"]);
                ?>
                    <a href="/<?= $item["page"] ?>"
                        class="w-full flex items-center gap-2.5 px-2 py-2 rounded-md text-left transition-colors duration-150"
                        style="font-size:14px;<?= $isActive ? 'background-color:#350d36;color:#ffffff;font-weight:600;' : 'color:#cfc3cf;font-weight:400;' ?>"
                        <?= !$isActive ? 'onmouseenter="this.style.backgroundColor=\'#350d36\';this.style.color=\'#ffffff\';" onmouseleave="this.style.backgroundColor=\'transparent\';this.style.color=\'#cfc3cf\';"' : '' ?>>
                        <i class="fas <?= $item["icon"] ?>" style="width:16px;text-align:center;"></i>
                        <?= $item["label"] ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>
    </div>

    <!-- Mes Groupes (scrollable) -->
    <div class="flex-1 overflow-y-auto min-h-0 scrollbar-none px-3" style="scrollbar-width:none;">
        <div class="pb-4">
            <p class="px-2 mb-1 font-semibold uppercase tracking-wider" style="font-size:11px;color:rgba(255,255,255,0.45);">Mes Groupes</p>
            <div class="space-y-0.5">
                <?php foreach ($myGroups as $g): ?>
                    <a href="/groupe/<?= $g->getId() ?>"
                        class="w-full flex items-center gap-2.5 px-2 py-1.5 rounded-md text-left transition-colors duration-150 sidebar-hover-bg"
                        style="font-size:14px;color:#cfc3cf;"
                        onmouseenter="this.style.backgroundColor='#350d36';this.style.color='#ffffff';"
                        onmouseleave="this.style.backgroundColor='transparent';this.style.color='#cfc3cf';">
                        <?php $c = groupColor($g->getNom());
                        $in = initials($g->getNom()); ?>
                        <span class="rounded-full flex items-center justify-center flex-shrink-0 font-semibold text-white" style="width:24px;height:24px;background-color:<?= $c ?>;font-size:9px;"><?= $in ?></span>
                        <span class="truncate"><?= htmlspecialchars($g->getNom()) ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Account -->
    <div class="px-3 py-3 relative flex-shrink-0" style="border-top:1px solid var(--color-sidebar-border);">
        <button onclick="toggleAccountMenu(event)" class="w-full flex items-center gap-2.5 px-2 py-2 rounded-md transition-colors duration-150" style="color:#cfc3cf;" onmouseenter="this.style.backgroundColor='#350d36';this.style.color='#ffffff';" onmouseleave="this.style.backgroundColor='transparent';this.style.color='#cfc3cf';">
            <?php
            $su = Session::isConnected() ? Session::getCurrentUser() : null;
            $displayName = $su ? $su->getNom() : 'Invité';
            $displayInitials = $su ? initials($su->getNom()) : '?';
            ?>
            <span class="rounded-full flex items-center justify-center flex-shrink-0 font-semibold text-white" style="width:28px;height:28px;background-color:#007a5a;font-size:10px;"><?= htmlspecialchars($displayInitials) ?></span>
            <span class="flex-1 text-left font-medium truncate" style="font-size:14px;color:#ffffff;"><?= htmlspecialchars($displayName) ?></span>
            <i class="fas fa-chevron-down" style="font-size:14px;color:#cfc3cf;"></i>
        </button>
        <div id="accountMenu" class="hidden absolute bottom-full left-3 right-3 mb-1 bg-white border border-border rounded-lg shadow-xl overflow-hidden z-50">
            <a href="#" class="w-full flex items-center gap-2.5 px-3 py-2.5 text-left hover:bg-secondary transition-colors duration-150" style="font-size:14px;color:#1d1c1d;">
                <i class="fas fa-user" style="width:14px;text-align:center;color:#616061;"></i> Profil
            </a>
            <a href="#" class="w-full flex items-center gap-2.5 px-3 py-2.5 text-left hover:bg-secondary transition-colors duration-150" style="font-size:14px;color:#1d1c1d;">
                <i class="fas fa-cog" style="width:14px;text-align:center;color:#616061;"></i> Paramètres
            </a>
            <a href="/logout" class="w-full flex items-center gap-2.5 px-3 py-2.5 text-left hover:bg-secondary transition-colors duration-150" style="font-size:14px;color:#1d1c1d;">
                <i class="fas fa-sign-out-alt" style="width:14px;text-align:center;color:#616061;"></i> Déconnexion
            </a>
        </div>
    </div>
</aside>

<script>
    function toggleAccountMenu(e) {
        e.stopPropagation();
        const menu = document.getElementById('accountMenu');
        menu.classList.toggle('hidden');
    }
    document.addEventListener('click', function() {
        const menu = document.getElementById('accountMenu');
        if (!menu.classList.contains('hidden')) menu.classList.add('hidden');
    });
</script>