<?php
$page = "favoris";
$pageTitle = "Mes Favoris — N4K";
require_once "inc/fonctions.php";

$resources = $GLOBALS["INITIAL_RESOURCES"];
$myGroupIds = getMyGroupIds();
$myGroups = array_filter($GLOBALS["INITIAL_GROUPS"], fn($g) => in_array($g->getId(), $myGroupIds));

$typeFilter = $_GET['type'] ?? '';
$search = $_GET['q'] ?? '';

$pinned = array_filter($resources, fn($r) => $r->isPinned());
$q = strtolower($search);
$filtered = array_filter($pinned, function ($r) use ($typeFilter, $q) {
  if ($typeFilter && $r->getType()->value !== $typeFilter) return false;
  if ($q && !str_contains(strtolower($r->getTitre()), $q) && !str_contains(strtolower($r->getMatiere()->getNom()), $q)) return false;
  return true;
});
$filtered = array_values($filtered);
?>
<?php include "inc/header.html.php"; ?>

<div class="flex h-screen overflow-hidden bg-background">
  <?php include "inc/sidebar.html.php"; ?>

  <div class="flex-1 flex flex-col min-w-0 overflow-hidden" style="width:0;">
    <?php include "inc/topbar.html.php"; ?>

    <div class="flex-1 overflow-y-auto">
      <div class="px-4 md:px-6 pt-4 md:pt-6 pb-4">
        <h2 class="text-foreground mb-4 font-lato" style="font-size:26px;">Mes Favoris</h2>
        <div class="flex flex-wrap items-center gap-2">
          <form method="GET" id="favoris-filter">
            <?php if ($search): ?><input type="hidden" name="q" value="<?= htmlspecialchars($search) ?>"><?php endif; ?>
            <select name="type" onchange="this.form.submit()"
              class="bg-input-background border border-border rounded-lg px-3 py-1.5 text-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
              style="font-size:14px;">
              <option value="">Tous les types</option>
              <?php foreach ($RESOURCE_TYPES as $t): ?>
                <option value="<?= $t ?>" <?= $typeFilter === $t ? 'selected' : '' ?>><?= $t ?></option>
              <?php endforeach; ?>
            </select>
          </form>
          <div class="relative flex-1 min-w-40">
            <i class="fas fa-search absolute" style="font-size:14px;color:#616061;left:10px;top:50%;transform:translateY(-50%);"></i>
            <form method="GET" class="m-0">
              <?php if ($typeFilter): ?><input type="hidden" name="type" value="<?= $typeFilter ?>"><?php endif; ?>
              <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Rechercher dans vos favoris…"
                class="w-full bg-input-background border border-border rounded-lg pl-8 pr-3 py-1.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
                style="font-size:14px;">
            </form>
          </div>
        </div>
      </div>
      <div class="border-t border-border">
        <?php if (empty($filtered)): ?>
          <div class="text-center py-16 text-muted-foreground" style="font-size:14px;">
            <?= empty($pinned) ? "Vous n'avez pas encore de favoris." : "Aucun résultat." ?>
          </div>
        <?php else:
          $i = 0;
          foreach ($filtered as $r):
            $showDiv = $i < count($filtered) - 1;
            include "includes/carte-ressource.html.php";
            $i++;
          endforeach;
        endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include "includes/mobile-sidebar.html.php"; ?>
<?php include "inc/footer.html.php"; ?>
