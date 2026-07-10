<?php
$page = "groupes";
$pageTitle = htmlspecialchars($groupe->getNom()) . " - N4K";
$ressources = $ressources ?? [];
$myGroupIds = getMyGroupIds();
$isMember = in_array($groupe->getId(), $myGroupIds);
$heroColor = groupColor($groupe->getNom());
$heroInitials = initials($groupe->getNom());

?>

<div class="flex h-screen overflow-hidden bg-background">
  <?php include "inc/sidebar.html.php"; ?>

  <div class="flex-1 flex flex-col min-w-0 overflow-hidden" style="width:0;">
    <?php include "inc/topbar.html.php"; ?>

    <div class="flex-1 overflow-y-auto">
      <!-- Hero -->
      <div class="px-6 py-8" style="background-color:<?= $heroColor ?>;">
        <div class="max-w-4xl mx-auto">
          <div class="flex items-center gap-4">
            <span class="w-16 h-16 rounded-full flex items-center justify-center text-white font-bold" style="background-color:rgba(255,255,255,0.2);font-size:24px;"><?= $heroInitials ?></span>
            <div class="flex-1">
              <h1 class="text-white font-lato font-bold" style="font-size:28px;"><?= htmlspecialchars($groupe->getNom()) ?></h1>
              <p class="text-white/80" style="font-size:14px;"><?= htmlspecialchars($groupe->getDescription()) ?></p>
              <p class="text-white/60" style="font-size:13px;margin-top:4px;">
                <i class="fas fa-users" style="font-size:12px;"></i>
                <?php if ($groupe->getVisibilite() === "Prive"): ?>
                  <i class="fas fa-lock" style="font-size:11px;margin-left:8px;"></i> Privé
                <?php else: ?>
                  <i class="fas fa-globe" style="font-size:11px;margin-left:8px;"></i> Public
                <?php endif; ?>
              </p>
            </div>
            <?php if ($isMember): ?>
              <a href="/groupe/<?= $groupe->getId() ?>/publier"
                class="flex items-center gap-2 px-4 py-2 rounded-lg text-white font-medium transition-opacity hover:opacity-90"
                style="background-color:rgba(255,255,255,0.2);font-size:14px;">
                <i class="fas fa-upload" style="font-size:14px;"></i> Publier dans ce groupe
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Feed -->
      <div class="px-6 py-6">
        <div class="max-w-4xl mx-auto">
          <?php if (empty($ressources)): ?>
            <p class="text-muted-foreground" style="font-size:14px;">Aucune ressource partagée dans ce groupe pour le moment.</p>
          <?php else:
            $i = 0;
            foreach ($ressources as $r):
              $showDiv = $i < count($ressources) - 1;
              include "includes/carte-ressource.html.php";
              $i++;
            endforeach;
          endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "includes/mobile-sidebar.html.php"; ?>