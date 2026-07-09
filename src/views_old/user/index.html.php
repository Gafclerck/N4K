<?php
// Mock / default data if not provided
if (!isset($user)) {
    $user = new \App\Entity\User();
    $user->setNom("Utilisateur");
}

// All Subjects available for filtering
if (!isset($allSubjects)) {
    $allSubjects = ['Algèbre', 'Analyse', 'Thermodynamique', 'Optique', 'Bases de données', 'Sécurité', 'React/Next.js'];
}

// Resource Types available for filtering
if (!isset($RESOURCE_TYPES)) {
    $RESOURCE_TYPES = ['Cours', 'TD', 'TP', 'Examen', 'Autre'];
}

// Default list of groups
if (!isset($myGroups)) {
    $myGroups = [
        ['id' => 1, 'name' => 'Mathématiques'],
        ['id' => 2, 'name' => 'Physique'],
        ['id' => 3, 'name' => 'Informatique'],
        ['id' => 4, 'name' => 'Algorithmique'],
        ['id' => 5, 'name' => 'Web Development'],
    ];
}

// Default list of resources
if (!isset($feedResources)) {
    $feedResources = [
        [
            'id' => 1,
            'title' => 'Introduction à l\'Algèbre Linéaire',
            'subject' => 'Algèbre',
            'type' => 'Cours',
            'description' => 'Un cours complet couvrant les espaces vectoriels, les applications linéaires et la diagonalisation des matrices avec des exemples corrigés.',
            'author' => 'Jean Dupont',
            'author_avatar' => 'JD',
            'created_at' => 'Il y a 2 heures',
            'likes' => 12,
            'comments_count' => 4,
            'is_pinned' => false,
            'file_name' => 'algebre_lineaire_ch1.pdf',
            'file_size' => '2.4 Mo',
        ],
        [
            'id' => 2,
            'title' => 'TD 3 - Électromagnétisme & Équations de Maxwell',
            'subject' => 'Physique',
            'type' => 'TD',
            'description' => 'Fiche de travaux dirigés sur les équations de Maxwell dans le vide et dans les milieux diélectriques. Niveau L2.',
            'author' => 'Marie Curie',
            'author_avatar' => 'MC',
            'created_at' => 'Hier',
            'likes' => 8,
            'comments_count' => 2,
            'is_pinned' => true,
            'file_name' => 'TD3_electromagnetisme.pdf',
            'file_size' => '850 Ko',
        ],
        [
            'id' => 3,
            'title' => 'Projet de Développement Web - Application PHP MVC',
            'subject' => 'Web Development',
            'type' => 'TP',
            'description' => 'Consignes pour le TP noté de programmation web. Mise en place d\'un routeur personnalisé, d\'un contrôleur abstrait et de la connexion PDO.',
            'author' => 'Alan Turing',
            'author_avatar' => 'AT',
            'created_at' => 'Il y a 3 jours',
            'likes' => 24,
            'comments_count' => 11,
            'is_pinned' => false,
            'file_name' => 'tp_php_mvc.zip',
            'file_size' => '1.2 Mo',
        ]
    ];
}

// Default list of recent resources (for the right panel)
if (!isset($recentResources)) {
    $recentResources = [
        [
            'id' => 1,
            'title' => 'Algèbre Linéaire - Chapitre 1',
            'subject' => 'Algèbre',
            'type' => 'Cours',
            'created_at' => 'Il y a 2 heures',
        ],
        [
            'id' => 2,
            'title' => 'TD3 Électromagnétisme',
            'subject' => 'Physique',
            'type' => 'TD',
            'created_at' => 'Hier',
        ],
        [
            'id' => 4,
            'title' => 'Analyse Numérique - Interpolation',
            'subject' => 'Analyse',
            'type' => 'Cours',
            'created_at' => 'Il y a 4 jours',
        ]
    ];
}

// Request parameters
$localSearch = $_GET['search'] ?? '';
$filterSubject = $_GET['subject'] ?? '';
$filterType = $_GET['type'] ?? '';
$activeGroupId = isset($_GET['group_id']) && $_GET['group_id'] !== '' ? (int)$_GET['group_id'] : null;
$showCreateModal = isset($_GET['create_group']) && $_GET['create_group'] == '1';
$recentPanelOpen = isset($_GET['panel']) ? $_GET['panel'] === 'open' : true;

// Handle toggle pin mock in session/memory (pure query param toggle)
$pinnedIds = isset($_GET['pinned_ids']) && $_GET['pinned_ids'] !== '' ? explode(',', $_GET['pinned_ids']) : [2]; // ID 2 is pinned by default
if (isset($_GET['toggle_pin'])) {
    $toggleId = (int)$_GET['toggle_pin'];
    if (in_array($toggleId, $pinnedIds)) {
        $pinnedIds = array_diff($pinnedIds, [$toggleId]);
    } else {
        $pinnedIds[] = $toggleId;
    }
}
$pinnedIdsStr = implode(',', $pinnedIds);

// Update pin states based on list
foreach ($feedResources as &$res) {
    $res['is_pinned'] = in_array($res['id'], $pinnedIds);
}
unset($res);

// Helper functions for dynamic styles & visuals
if (!function_exists('initials')) {
    function initials($name)
    {
        $words = explode(' ', trim($name));
        if (count($words) >= 2) {
            return mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
        }
        return mb_strtoupper(mb_substr($name, 0, 2));
    }
}

if (!function_exists('groupColor')) {
    function groupColor($name)
    {
        $hash = crc32($name);
        $h = abs($hash) % 360;
        return "hsl({$h}, 65%, 40%)";
    }
}

// Filtering resources dynamically
$filteredResources = [];
foreach ($feedResources as $r) {
    if ($filterSubject !== '' && $r['subject'] !== $filterSubject) {
        continue;
    }
    if ($filterType !== '' && $r['type'] !== $filterType) {
        continue;
    }
    if ($localSearch !== '') {
        $q = mb_strtolower($localSearch);
        if (mb_strpos(mb_strtolower($r['title']), $q) === false && mb_strpos(mb_strtolower($r['description']), $q) === false) {
            continue;
        }
    }
    if ($activeGroupId !== null) {
        // Group association mock
        if ($activeGroupId === 1 && $r['subject'] !== 'Algèbre' && $r['subject'] !== 'Analyse') continue;
        if ($activeGroupId === 2 && $r['subject'] !== 'Physique') continue;
        if ($activeGroupId === 5 && $r['subject'] !== 'Web Development') continue;
        // Keep other groups empty
        if ($activeGroupId === 3 || $activeGroupId === 4) continue;
    }
    $filteredResources[] = $r;
}

$rightPanelWidth = $recentPanelOpen ? '256px' : '0px';
$panelClass = $recentPanelOpen ? 'flex w-64' : 'hidden xl:flex xl:w-64';
?>

<!-- Modal for creating group -->
<?php if ($showCreateModal): ?>
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 backdrop-blur-xs">
        <div class="bg-card border border-border rounded-xl max-w-md w-full shadow-lg p-6 relative">
            <a href="?<?= htmlspecialchars(http_build_query(array_merge(array_diff_key($_GET, ['create_group' => 1]), ['pinned_ids' => $pinnedIdsStr]))) ?>" class="absolute top-4 right-4 text-muted-foreground hover:text-foreground">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </a>
            <h2 class="text-xl font-semibold mb-4 text-foreground">Créer un nouveau groupe</h2>
            <form method="POST" action="" class="space-y-4">
                <div>
                    <label class="block text-foreground font-medium mb-1.5 text-sm">Nom du groupe</label>
                    <input type="text" name="group_name" placeholder="Ex: Mathématiques, Physique..." required class="w-full bg-input-background border border-border rounded-lg px-3 py-2 text-foreground outline-none focus:ring-2 focus:ring-primary/30 text-sm" />
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <a href="?<?= htmlspecialchars(http_build_query(array_merge(array_diff_key($_GET, ['create_group' => 1]), ['pinned_ids' => $pinnedIdsStr]))) ?>" class="px-4 py-2 border border-border rounded-lg text-sm font-semibold hover:bg-secondary transition-colors text-muted-foreground">
                        Annuler
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg text-white text-sm font-semibold hover:opacity-90 transition-opacity" style="background-color: #007a5a;">
                        Créer
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<div class="flex-1 flex overflow-hidden min-w-0">
    <!-- ── Center column ─────────────────────────────────────────────── -->
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">
        <!-- Group strip -->
        <div class="px-4 py-3 border-b border-border flex-shrink-0">
            <div class="flex gap-4 overflow-x-auto pb-1" style="scrollbar-width: none;">
                <!-- Create group action button -->
                <a
                    href="?<?= htmlspecialchars(http_build_query(array_merge($_GET, ['create_group' => 1], ['pinned_ids' => $pinnedIdsStr]))) ?>"
                    class="flex flex-col items-center gap-1 flex-shrink-0 cursor-pointer group">
                    <div
                        class="w-11 h-11 rounded-full border-2 border-dashed flex items-center justify-center hover:border-primary transition-colors duration-150"
                        style="border-color: #ecb22e;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ecb22e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                    </div>
                    <span class="text-muted-foreground text-center leading-tight group-hover:text-foreground transition-colors" style="font-size: 10px; max-width: 52px;">Créer</span>
                </a>

                <!-- Groups mapping -->
                <?php foreach ($myGroups as $g): ?>
                    <?php
                    $isGroupActive = ($activeGroupId === $g['id']);
                    $groupTargetUrl = '?' . http_build_query(array_merge($_GET, [
                        'group_id' => $isGroupActive ? '' : $g['id'],
                        'pinned_ids' => $pinnedIdsStr
                    ]));
                    ?>
                    <a
                        href="<?= htmlspecialchars($groupTargetUrl) ?>"
                        class="flex flex-col items-center gap-1 flex-shrink-0 cursor-pointer group">
                        <div
                            class="w-11 h-11 rounded-full flex items-center justify-center text-white font-semibold shadow-sm group-hover:scale-105 transition-all duration-150"
                            style="
                background-color: <?= groupColor($g['name']) ?>;
                font-size: 13px;
                box-shadow: <?= $isGroupActive ? '0 0 0 2.5px #ecb22e' : 'none' ?>;
              ">
                            <?= initials($g['name']) ?>
                        </div>
                        <span
                            class="text-center leading-tight truncate group-hover:text-foreground transition-colors"
                            style="
                font-size: 10px;
                max-width: 52px;
                color: <?= $isGroupActive ? '#007a5a' : '#8a8a8a' ?>;
                font-weight: <?= $isGroupActive ? 600 : 400 ?>;
              ">
                            <?= htmlspecialchars($g['name']) ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Filter row -->
        <form method="GET" action="" class="px-4 py-2.5 border-b border-border flex-shrink-0 flex flex-wrap items-center gap-2">
            <!-- Preserve group, panel, and pins states -->
            <?php if ($activeGroupId !== null): ?>
                <input type="hidden" name="group_id" value="<?= $activeGroupId ?>">
            <?php endif; ?>
            <?php if (isset($_GET['panel'])): ?>
                <input type="hidden" name="panel" value="<?= htmlspecialchars($_GET['panel']) ?>">
            <?php endif; ?>
            <input type="hidden" name="pinned_ids" value="<?= htmlspecialchars($pinnedIdsStr) ?>">

            <span class="text-muted-foreground flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="21" x2="4" y2="14"></line>
                    <line x1="4" y1="10" x2="4" y2="3"></line>
                    <line x1="12" y1="21" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12" y2="3"></line>
                    <line x1="20" y1="21" x2="20" y2="16"></line>
                    <line x1="20" y1="12" x2="20" y2="3"></line>
                    <line x1="2" y1="14" x2="6" y2="14"></line>
                    <line x1="10" y1="8" x2="14" y2="8"></line>
                    <line x1="18" y1="16" x2="22" y2="16"></line>
                </svg>
            </span>

            <!-- Search Input -->
            <div class="relative flex-1 min-w-[128px] max-w-xs">
                <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-muted-foreground">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
                <input
                    type="text"
                    name="search"
                    value="<?= htmlspecialchars($localSearch) ?>"
                    placeholder="Filtrer le feed…"
                    class="w-full bg-input-background border border-border rounded-md pl-7 pr-2 py-1 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
                    style="font-size: 13px;" />
            </div>

            <!-- Subject dropdown -->
            <select
                name="subject"
                class="bg-input-background border border-border rounded-md px-2 py-1 text-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow cursor-pointer"
                style="font-size: 13px;"
                onchange="this.form.submit()">
                <option value="">Toutes matières</option>
                <?php foreach ($allSubjects as $s): ?>
                    <option value="<?= htmlspecialchars($s) ?>" <?= $filterSubject === $s ? 'selected' : '' ?>><?= htmlspecialchars($s) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Type dropdown -->
            <select
                name="type"
                class="bg-input-background border border-border rounded-md px-2 py-1 text-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow cursor-pointer"
                style="font-size: 13px;"
                onchange="this.form.submit()">
                <option value="">Tous les types</option>
                <?php foreach ($RESOURCE_TYPES as $t): ?>
                    <option value="<?= htmlspecialchars($t) ?>" <?= $filterType === $t ? 'selected' : '' ?>><?= htmlspecialchars($t) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Search submit fallback for no-js -->
            <button type="submit" class="px-2 py-1 rounded bg-secondary text-foreground hover:bg-border transition-colors text-xs font-semibold cursor-pointer">
                Filtrer
            </button>

            <!-- Clear filters action -->
            <?php if ($filterSubject !== '' || $filterType !== '' || $localSearch !== ''): ?>
                <?php
                $clearUrl = '?';
                $params = [];
                if ($activeGroupId !== null) {
                    $params['group_id'] = $activeGroupId;
                }
                if (isset($_GET['panel'])) {
                    $params['panel'] = $_GET['panel'];
                }
                $params['pinned_ids'] = $pinnedIdsStr;
                $clearUrl .= http_build_query($params);
                ?>
                <a
                    href="<?= htmlspecialchars($clearUrl) ?>"
                    class="text-muted-foreground hover:text-foreground transition-colors text-xs">
                    Effacer
                </a>
            <?php endif; ?>

            <!-- Panel open button for mobile -->
            <a
                href="?<?= htmlspecialchars(http_build_query(array_merge($_GET, ['panel' => $recentPanelOpen ? 'closed' : 'open'], ['pinned_ids' => $pinnedIdsStr]))) ?>"
                class="xl:hidden bg-input-background border border-border rounded-md px-2 py-1 text-foreground hover:bg-secondary transition-colors flex items-center gap-1.5 ml-auto"
                style="font-size: 13px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="9" y1="3" x2="9" y2="21"></line>
                </svg>
                <span>Récents</span>
            </a>
        </form>

        <!-- Detailed feed -->
        <div class="flex-1 overflow-y-auto" style="scrollbar-width: none;">
            <?php if (empty($filteredResources)): ?>
                <div class="text-center py-16 text-muted-foreground" style="font-size: 14px;">
                    Aucune ressource correspondante.
                </div>
            <?php else: ?>
                <?php foreach ($filteredResources as $r): ?>
                    <div class="p-6 border-b border-border hover:bg-card/20 transition-colors duration-150">
                        <!-- Card Header -->
                        <div class="flex items-start justify-between gap-4 mb-3">
                            <div class="flex items-center gap-3">
                                <!-- User Avatar -->
                                <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-semibold text-xs" style="background-color: <?= groupColor($r['author']) ?>;">
                                    <?= htmlspecialchars($r['author_avatar']) ?>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-foreground font-semibold text-sm"><?= htmlspecialchars($r['author']) ?></span>
                                        <span class="text-muted-foreground text-xs">• <?= htmlspecialchars($r['created_at']) ?></span>
                                    </div>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <!-- Type Badge -->
                                        <?php
                                        $typeColors = [
                                            'Cours' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                            'TD' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                            'TP' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                            'Examen' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                            'Autre' => 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400',
                                        ];
                                        $typeClass = $typeColors[$r['type']] ?? $typeColors['Autre'];
                                        ?>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold tracking-wide uppercase <?= $typeClass ?>">
                                            <?= htmlspecialchars($r['type']) ?>
                                        </span>
                                        <!-- Subject Badge -->
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-secondary text-muted-foreground font-medium">
                                            <?= htmlspecialchars($r['subject']) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Pin toggle link -->
                            <a href="?<?= htmlspecialchars(http_build_query(array_merge($_GET, ['toggle_pin' => $r['id'], 'pinned_ids' => $pinnedIdsStr]))) ?>" class="p-1 rounded hover:bg-secondary transition-colors text-muted-foreground hover:text-foreground">
                                <?php if ($r['is_pinned']): ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#ecb22e" stroke="#ecb22e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="17" x2="12" y2="22"></line>
                                        <path d="M5 17h14v-1.76a2 2 0 0 0-.44-1.24l-2.32-2.9A4 4 0 0 1 15 8.62V4H9v4.62c0 .87-.28 1.71-.78 2.38l-2.35 3.13a2 2 0 0 0-.43 1.25V17z"></path>
                                    </svg>
                                <?php else: ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="17" x2="12" y2="22"></line>
                                        <path d="M5 17h14v-1.76a2 2 0 0 0-.44-1.24l-2.32-2.9A4 4 0 0 1 15 8.62V4H9v4.62c0 .87-.28 1.71-.78 2.38l-2.35 3.13a2 2 0 0 0-.43 1.25V17z"></path>
                                    </svg>
                                <?php endif; ?>
                            </a>
                        </div>

                        <!-- Card Content -->
                        <div class="mb-4">
                            <h3 class="text-base font-semibold text-foreground mb-1.5"><?= htmlspecialchars($r['title']) ?></h3>
                            <p class="text-muted-foreground text-sm leading-relaxed"><?= htmlspecialchars($r['description']) ?></p>
                        </div>

                        <!-- File attachment info -->
                        <?php if (!empty($r['file_name'])): ?>
                            <div class="flex items-center justify-between p-3 border border-border rounded-lg bg-card/50 hover:bg-card mb-4 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-secondary rounded text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" y1="13" x2="8" y2="13"></line>
                                            <line x1="16" y1="17" x2="8" y2="17"></line>
                                            <polyline points="10 9 9 9 8 9"></polyline>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-foreground"><?= htmlspecialchars($r['file_name']) ?></p>
                                        <p class="text-xs text-muted-foreground"><?= htmlspecialchars($r['file_size']) ?></p>
                                    </div>
                                </div>
                                <a href="#" class="p-2 hover:bg-secondary rounded text-muted-foreground hover:text-foreground transition-colors" title="Télécharger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Card Actions -->
                        <div class="flex items-center gap-6">
                            <button class="flex items-center gap-1.5 text-xs text-muted-foreground hover:text-foreground transition-colors cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                                </svg>
                                <span><?= htmlspecialchars($r['likes']) ?></span>
                            </button>
                            <button class="flex items-center gap-1.5 text-xs text-muted-foreground hover:text-foreground transition-colors cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                <span><?= htmlspecialchars($r['comments_count']) ?></span>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- ── Right column — Récemment partagés ─────────────────────────── -->
    <div
        class="flex-col border-l border-border flex-shrink-0 overflow-hidden bg-background <?= $panelClass ?>"
        style="width: <?= $rightPanelWidth ?>; transition: width 250ms ease;">
        <!-- Close button row — only visible below xl -->
        <div class="flex items-center justify-between px-4 py-2.5 border-b border-border flex-shrink-0">
            <p class="text-muted-foreground font-semibold uppercase tracking-wider whitespace-nowrap" style="font-size: 11px;">
                Récemment partagés
            </p>
            <a
                href="?<?= htmlspecialchars(http_build_query(array_merge($_GET, ['panel' => 'closed'], ['pinned_ids' => $pinnedIdsStr]))) ?>"
                class="xl:hidden p-1 rounded hover:bg-secondary transition-colors text-muted-foreground flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </a>
        </div>

        <!-- Recent items list -->
        <div class="flex-1 overflow-y-auto p-2 space-y-1" style="min-width: 256px; scrollbar-width: none;">
            <?php foreach ($recentResources as $r): ?>
                <a
                    href="?<?= htmlspecialchars(http_build_query(array_merge($_GET, ['search' => $r['title']], ['pinned_ids' => $pinnedIdsStr]))) ?>"
                    class="block p-3 rounded-lg hover:bg-card border border-transparent hover:border-border transition-all duration-150 cursor-pointer group">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-foreground truncate group-hover:text-primary transition-colors">
                                <?= htmlspecialchars($r['title']) ?>
                            </p>
                            <div class="flex items-center gap-1.5 mt-1 text-[10px] text-muted-foreground">
                                <span class="font-medium text-foreground"><?= htmlspecialchars($r['subject']) ?></span>
                                <span>•</span>
                                <span><?= htmlspecialchars($r['created_at']) ?></span>
                            </div>
                        </div>
                        <!-- Type Icon/Badge -->
                        <span class="flex-shrink-0 px-1.5 py-0.5 rounded text-[8px] font-bold uppercase bg-secondary text-muted-foreground">
                            <?= htmlspecialchars($r['type']) ?>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>