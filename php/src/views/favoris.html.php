<?php
$favoris = $favoris ?? [];
// favori resources already have isFavori = true set by controller
?>
<div class="flex h-screen overflow-hidden bg-background">
  <?php include "inc/sidebar.html.php"; ?>

  <div class="flex-1 flex flex-col min-w-0 overflow-hidden" style="width:0;">
    <?php include "inc/topbar.html.php"; ?>

    <div class="flex-1 overflow-y-auto">
      <div class="px-4 md:px-6 pt-4 md:pt-6 pb-4">
        <h2 class="text-foreground mb-4 font-lato" style="font-size:26px;">Mes Favoris</h2>
      </div>
      <div class="border-t border-border">
        <?php if (empty($favoris)): ?>
          <div class="text-center py-16 text-muted-foreground" style="font-size:14px;">
            Vous n'avez pas encore de favoris.
          </div>
        <?php else:
          $i = 0;
          foreach ($favoris as $f):
            $r = $f->getRessource();
            if (!$r) continue;
            $showDiv = $i < count($favoris) - 1;
            include "includes/carte-ressource.html.php";
            $i++;
          endforeach;
        endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include "includes/mobile-sidebar.html.php"; ?>
