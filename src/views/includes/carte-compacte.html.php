<?php
$tc = $GLOBALS['TYPE_COLORS'][$r->getType()->value];
$pinned = $r->isPinned();
?>
<div class="px-4 py-3 hover:bg-[#f0faf6] transition-colors duration-150 cursor-pointer">
  <div class="flex items-start justify-between gap-2">
    <div class="flex-1 min-w-0">
      <div class="flex items-center gap-1.5 mb-1">
        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded font-medium flex-shrink-0" style="background-color:<?= $tc["bg"] ?>;color:<?= $tc["text"] ?>;font-size:10px;">
          <?= $r->getType()->value ?>
        </span>
      </div>
      <p class="text-foreground font-medium leading-snug truncate" style="font-size:13px;">
        <?= htmlspecialchars($r->getTitre()) ?>
      </p>
      <p class="text-muted-foreground" style="font-size:11px;">
        <?= htmlspecialchars($r->getAuteur()->getNom()) ?> · <?= $r->getCreatedAt() ?>
      </p>
    </div>
    <span class="mt-0.5 p-1 rounded flex-shrink-0" style="color:<?= $pinned ? '#ecb22e' : '#c0c0c0' ?>;">
      <i class="fas fa-thumbtack" style="font-size:13px;"></i>
    </span>
  </div>
</div>
<?php if ($showDivider ?? true): ?>
<div class="border-b border-border"></div>
<?php endif; ?>
