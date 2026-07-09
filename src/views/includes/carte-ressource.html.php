<?php
$tc = $GLOBALS['TYPE_COLORS'][$r->getType()->value];
$pinned = $r->isPinned();
?>
<div class="px-5 py-4 transition-colors duration-150" style="border-left:3px solid transparent;">
  <div class="flex items-start justify-between gap-3 mb-2">
    <div class="flex flex-wrap items-center gap-2 min-w-0">
      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded font-medium flex-shrink-0" style="background-color:<?= $tc["bg"] ?>;color:<?= $tc["text"] ?>;font-size:11px;">
        <i class="fas <?= typeIconClass($r->getType()->value) ?>" style="font-size:11px;"></i>
        <?= $r->getType()->value ?>
      </span>
      <span class="text-muted-foreground truncate" style="font-size:12px;">
        <?= htmlspecialchars($r->getMatiere()->getNom()) ?> · <?= htmlspecialchars($r->getGroupe()->getNom()) ?>
      </span>
    </div>
    <div class="flex items-center gap-2 flex-shrink-0">
      <span class="text-muted-foreground" style="font-size:11px;"><?= $r->getCreatedAt() ?></span>
      <span class="p-1.5 rounded-md" style="color:<?= $pinned ? '#ecb22e' : '#8a8a8a' ?>;">
        <i class="fas fa-thumbtack" style="font-size:15px;<?= $pinned ? 'color:#ecb22e;' : '' ?>"></i>
      </span>
    </div>
  </div>

  <div class="flex gap-3">
    <div class="hidden sm:flex flex-shrink-0 w-16 h-16 rounded-lg items-center justify-center" style="background-color:<?= $tc["bg"] ?>18;">
      <span style="color:<?= $tc["bg"] ?>;"><i class="fas <?= typeIconClass($r->getType()->value) ?>" style="font-size:28px;"></i></span>
    </div>
    <div class="flex-1 min-w-0">
      <h3 class="text-foreground leading-snug mb-1 font-lato" style="font-size:18px;">
        <?= htmlspecialchars($r->getTitre()) ?>
      </h3>
      <p class="text-muted-foreground mb-2" style="font-size:12px;">
        <span class="font-medium" style="color:#007a5a;"><?= htmlspecialchars($r->getAuteur()->getNom()) ?></span>
        — <?= htmlspecialchars($r->getDescription()) ?>
      </p>
      <div class="flex items-center gap-4 text-muted-foreground" style="font-size:12px;">
        <span class="flex items-center gap-1"><i class="fas fa-eye" style="font-size:12px;"></i> <?= $r->getViews() ?></span>
        <span class="flex items-center gap-1"><i class="fas fa-download" style="font-size:12px;"></i> <?= $r->getDownloads() ?></span>
        <span class="flex items-center gap-1"><i class="fas fa-comment" style="font-size:12px;"></i> <?= count($r->getComments()) ?></span>
      </div>
    </div>
  </div>

  <?php $comments = $r->getComments(); if (!empty($comments)): ?>
  <div class="mt-3 space-y-2 border-t border-border pt-3">
    <?php foreach (array_slice($comments, 0, 3) as $c):
      $cu = $c->getUser();
      $cc = groupColor($cu->getNom());
      $ci = initials($cu->getNom());
    ?>
    <div class="flex items-start gap-2">
      <span class="rounded-full flex items-center justify-center flex-shrink-0 font-semibold text-white" style="width:22px;height:22px;background-color:<?= $cc ?>;font-size:8px;"><?= $ci ?></span>
      <div>
        <span class="font-medium text-foreground" style="font-size:12px;"><?= htmlspecialchars($cu->getNom()) ?></span>
        <span class="text-muted-foreground" style="font-size:12px;"> — <?= htmlspecialchars($c->getMessage()) ?></span>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>
<?php if ($showDivider ?? true): ?>
<div class="border-b border-border"></div>
<?php endif; ?>
