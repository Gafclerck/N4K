<?php
$page = "index";
$pageTitle = "Accueil - N4K";

$groups = $GLOBALS['INITIAL_GROUPS'];
$myGroupIds = getMyGroupIds();
$myGroups = array_filter($groups, fn($g) => in_array($g->getId(), $myGroupIds));

$resources = $resources ?? [];
$recentResources = $recentResources ?? [];
$allMatieres = $allMatieres ?? [];

$activeGroupId = $_GET['group'] ?? null;
if ($activeGroupId) $activeGroupId = (int)$activeGroupId;
$filterSubject = $_GET['subject'] ?? '';
$filterType = $_GET['type'] ?? '';
$search = $_GET['q'] ?? '';

$q = strtolower($search);
$feedResources = array_filter($resources, function ($r) use ($activeGroupId, $filterSubject, $filterType, $q) {
  if ($activeGroupId && $r->getGroupeId() !== $activeGroupId) return false;
  if ($filterType && $r->getType()->value !== $filterType) return false;
  if ($q && !str_contains(strtolower($r->getTitre()), $q)) return false;
  return true;
});
$feedResources = array_values($feedResources);

?>

<div class="flex h-screen overflow-hidden bg-background">
  <?php include "inc/sidebar.html.php"; ?>

  <div class="flex-1 flex flex-col min-w-0 overflow-hidden" style="width:0;">
    <?php include "inc/topbar.html.php"; ?>

    <!-- Main content -->
    <div class="flex-1 flex overflow-hidden min-w-0">

      <!-- Center: Feed -->
      <div class="flex-1 flex flex-col overflow-hidden min-w-0">

        <!-- Group strip -->
        <div class="px-4 py-3 border-b border-border flex-shrink-0">
          <div class="flex gap-4 overflow-x-auto pb-1 scrollbar-none" style="scrollbar-width:none;">
            <a href="/groupes?modal=create" class="flex flex-col items-center gap-1 flex-shrink-0 cursor-pointer">
              <span class="w-11 h-11 rounded-full border-2 border-dashed flex items-center justify-center hover:border-primary transition-colors duration-150" style="border-color:#ecb22e;">
                <i class="fas fa-plus" style="font-size:16px;color:#ecb22e;"></i>
              </span>
              <span class="text-muted-foreground text-center leading-tight" style="font-size:10px;max-width:52px;">Créer</span>
            </a>
            <?php foreach ($myGroups as $g):
              $isActive = $activeGroupId === (int)$g->getId();
              $c = groupColor($g->getNom());
              $in = initials($g->getNom());
            ?>
              <a href="?<?= $isActive ? '' : 'group=' . $g->getId() ?>" class="flex flex-col items-center gap-1 flex-shrink-0 cursor-pointer">
                <span class="w-11 h-11 rounded-full flex items-center justify-center text-white font-semibold" style="background-color:<?= $c ?>;font-size:13px;<?= $isActive ? 'box-shadow:0 0 0 2.5px #ecb22e;' : '' ?>transition:box-shadow 0.15s;">
                  <?= $in ?>
                </span>
                <span class="text-center leading-tight truncate" style="font-size:10px;max-width:52px;<?= $isActive ? 'color:#007a5a;font-weight:600;' : 'color:#8a8a8a;font-weight:400;' ?>">
                  <?= htmlspecialchars($g->getNom()) ?>
                </span>
              </a>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Filter row -->
        <div class="px-4 py-2.5 border-b border-border flex-shrink-0 flex flex-wrap items-center gap-2">
          <i class="fas fa-sliders-h text-muted-foreground flex-shrink-0" style="font-size:14px;"></i>
          <div class="relative flex-1 min-w-32 max-w-xs">
            <i class="fas fa-search absolute" style="font-size:13px;color:#616061;left:10px;top:50%;transform:translateY(-50%);"></i>
            <form method="GET" class="m-0">
              <?php if ($activeGroupId): ?><input type="hidden" name="group" value="<?= $activeGroupId ?>"><?php endif; ?>
              <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Filtrer le feed…"
                class="w-full bg-input-background border border-border rounded-md pl-7 pr-2 py-1 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
                style="font-size:13px;">
            </form>
          </div>
          <form method="GET" id="filter-form">
            <?php if ($activeGroupId): ?><input type="hidden" name="group" value="<?= $activeGroupId ?>"><?php endif; ?>
            <?php if ($search): ?><input type="hidden" name="q" value="<?= htmlspecialchars($search) ?>"><?php endif; ?>
            <select name="subject" onchange="this.form.submit()"
              class="bg-input-background border border-border rounded-md px-2 py-1 text-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
              style="font-size:13px;">
              <option value="">Toutes matières</option>
              <?php foreach ($allMatieres as $m): ?>
                <option value="<?= htmlspecialchars($m->getNom()) ?>" <?= $filterSubject === $m->getNom() ? 'selected' : '' ?>><?= htmlspecialchars($m->getNom()) ?></option>
              <?php endforeach; ?>
            </select>
            <select name="type" onchange="this.form.submit()"
              class="bg-input-background border border-border rounded-md px-2 py-1 text-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
              style="font-size:13px;">
              <option value="">Tous les types</option>
              <?php foreach ($RESOURCE_TYPES as $t): ?>
                <option value="<?= $t ?>" <?= $filterType === $t ? 'selected' : '' ?>><?= $t ?></option>
              <?php endforeach; ?>
            </select>
          </form>
          <?php if ($filterSubject || $filterType || $search): ?>
            <a href="index.php" class="text-muted-foreground hover:text-foreground transition-colors" style="font-size:12px;">Effacer</a>
          <?php endif; ?>
        </div>

        <!-- Detailed feed -->
        <div class="flex-1 overflow-y-auto scrollbar-none" style="scrollbar-width:none;">
          <?php if (empty($feedResources)): ?>
            <div class="text-center py-16 text-muted-foreground" style="font-size:14px;">Aucune ressource correspondante.</div>
          <?php else:
            $i = 0;
            foreach ($feedResources as $r):
              $showDiv = $i < count($feedResources) - 1;
              include "includes/carte-ressource.html.php";
              $i++;
            endforeach;
          endif; ?>
        </div>
      </div>

      <!-- Right: Recent Panel -->
      <div id="recentPanel" class="flex flex-col border-l border-border flex-shrink-0 overflow-hidden bg-background transition-width" style="width:256px;min-width:256px;">
        <div class="flex items-center justify-between px-4 py-2.5 border-b border-border flex-shrink-0 xl:hidden">
          <p class="text-muted-foreground font-semibold uppercase tracking-wider whitespace-nowrap" style="font-size:11px;">Récemment partagés</p>
          <button onclick="toggleRecentPanel()" class="p-1 rounded hover:bg-secondary transition-colors text-muted-foreground flex-shrink-0">
            <i class="fas fa-times" style="font-size:14px;"></i>
          </button>
        </div>
        <div class="px-4 py-3 border-b border-border flex-shrink-0 hidden xl:block">
          <p class="text-muted-foreground font-semibold uppercase tracking-wider" style="font-size:11px;">Récemment partagés</p>
        </div>
        <div class="flex-1 overflow-y-auto scrollbar-none" style="scrollbar-width:none;">
          <?php
          $count = count($recentResources);
          foreach ($recentResources as $i => $r):
            $showDiv = $i < $count - 1;
            include "includes/carte-compacte.html.php";
          endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function setRecentPanel(open) {
    const panel = document.getElementById('recentPanel');
    if (open) {
      panel.style.width = '256px';
      panel.style.minWidth = '256px';
      panel.style.borderLeft = '';
      panel.style.overflow = '';
    } else {
      panel.style.width = '0px';
      panel.style.minWidth = '0px';
      panel.style.borderLeft = 'none';
      panel.style.overflow = 'hidden';
    }
  }

  function toggleRecentPanel() {
    const panel = document.getElementById('recentPanel');
    const isOpen = panel.style.width !== '0px' && panel.style.width !== '';
    setRecentPanel(isOpen ? false : true);
  }

  function updateRecentPanelForScreen() {
    const isXl = window.matchMedia('(min-width: 1280px)').matches;
    const panel = document.getElementById('recentPanel');
    if (isXl) {
      panel.style.width = '';
      panel.style.minWidth = '';
      panel.style.borderLeft = '';
      panel.style.overflow = '';
      panel.classList.add('xl\\:flex');
    } else {
      panel.style.width = '0px';
      panel.style.minWidth = '0px';
      panel.style.borderLeft = 'none';
      panel.style.overflow = 'hidden';
    }
  }

  window.addEventListener('resize', updateRecentPanelForScreen);
  updateRecentPanelForScreen();
</script>

<?php include "includes/mobile-sidebar.html.php"; ?>
