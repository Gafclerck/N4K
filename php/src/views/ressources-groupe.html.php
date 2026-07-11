<?php
$ressources = $ressources ?? [];
$groupeId = $groupeId ?? 0;
?>
<div class="flex h-screen overflow-hidden bg-background">
  <?php include "inc/sidebar.html.php"; ?>

  <div class="flex-1 flex flex-col min-w-0 overflow-hidden" style="width:0;">
    <?php include "inc/topbar.html.php"; ?>

    <div class="flex-1 overflow-y-auto">
      <div class="px-4 md:px-6 pt-4 md:pt-6 pb-4">
        <h2 class="text-foreground mb-1 font-lato" style="font-size:26px;">Ressources du groupe</h2>
        <p class="text-muted-foreground mb-4" style="font-size:14px;">
          <?= count($ressources) ?> ressource<?= count($ressources) !== 1 ? "s" : "" ?>
        </p>
      </div>
      <div class="border-t border-border">
        <?php if (empty($ressources)): ?>
          <div class="text-center py-16 text-muted-foreground" style="font-size:14px;">
            Aucune ressource dans ce groupe.
          </div>
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

<?php include "includes/mobile-sidebar.html.php"; ?>
