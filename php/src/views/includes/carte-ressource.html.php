<?php
$tc = $GLOBALS['TYPE_COLORS'][$r->getType()->value];
$pinned = $r->isPinned();
$hasFile = $r->getFilepath() !== null;
$previewable = $hasFile && in_array($r->getMimeType(), [
  'application/pdf',
  'image/jpeg',
  'image/png',
  'image/gif',
  'video/mp4',
]);

?>
<div class="px-5 py-4 transition-colors duration-150" style="border-left:3px solid transparent;">
  <div class="flex items-start justify-between gap-3 mb-2">
    <div class="flex flex-wrap items-center gap-2 min-w-0">
      <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded font-medium flex-shrink-0" style="background-color:<?= $tc["bg"] ?>;color:<?= $tc["text"] ?>;font-size:11px;">
        <i class="fas <?= typeIconClass($r->getType()->value) ?>" style="font-size:11px;"></i>
        <?= $r->getType()->value ?>
      </span>
      <?php if ($hasFile): ?>
        <span class="inline-flex items-center px-1.5 py-0.5 rounded font-medium" style="background-color:#e8e8e8;color:#1d1c1d;font-size:10px;">
          <i class="fas <?= fileIconClass($r->getMimeType()) ?>" style="font-size:10px;margin-right:3px;"></i>
          <?= fileExtension($r->getMimeType()) ?>
        </span>
      <?php endif; ?>
      <span class="text-muted-foreground truncate" style="font-size:12px;">
        <?= htmlspecialchars($r->getMatiere()?->getNom() ?? 'Sans matière') ?> · <?= htmlspecialchars($r->getGroupe()?->getNom() ?? 'Public') ?>
      </span>
    </div>
    <div class="flex items-center gap-2 flex-shrink-0">
      <?php if (\App\config\Session::isConnected() && $r->isFavori() !== null): ?>
        <form action="/favoris/toggle" method="POST" class="inline">
          <input type="hidden" name="ressource_id" value="<?= $r->getId() ?>">
          <button type="submit" class="p-1.5 rounded-md hover:bg-secondary transition-colors" style="color:<?= $r->isFavori() ? '#ecb22e' : '#8a8a8a' ?>;">
            <i class="<?= $r->isFavori() ? 'fas' : 'far' ?> fa-star" style="font-size:15px;"></i>
          </button>
        </form>
      <?php endif; ?>
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
      <a href="/ressource/<?= $r->getId() ?>" class="block text-foreground leading-snug mb-1 font-lato hover:opacity-80 transition-opacity" style="font-size:18px;">
        <?= htmlspecialchars($r->getTitre()) ?>
      </a>
      <p class="text-muted-foreground mb-2" style="font-size:12px;">
        <span class="font-medium" style="color:#007a5a;"><?= htmlspecialchars($r->getAuteur()?->getNom() ?? 'Anonyme') ?></span>
        — <?= htmlspecialchars($r->getDescription()) ?>
      </p>
      <div class="flex items-center gap-4 text-muted-foreground" style="font-size:12px;">
        <span class="flex items-center gap-1"><i class="fas fa-eye" style="font-size:12px;"></i> <?= $r->getViews() ?></span>
        <span class="flex items-center gap-1"><i class="fas fa-download" style="font-size:12px;"></i> <?= $r->getDownloads() ?></span>
        <?php if ($hasFile): ?>
          <span class="flex items-center gap-1" style="color:#007a5a;">
            <i class="fas <?= fileIconClass($r->getMimeType()) ?>" style="font-size:12px;"></i>
            <?= formatFileSize($r->getFileSize()) ?>
          </span>
          <?php if ($previewable): ?>
            <a href="/ressource/<?= $r->getId() ?>/view" class="flex items-center gap-1 hover:text-primary transition-colors" style="font-size:12px;color:#007a5a;">
              <i class="fas fa-eye" style="font-size:12px;"></i> Voir
            </a>
          <?php endif; ?>
          <a href="/ressource/<?= $r->getId() ?>/download" class="flex items-center gap-1 hover:text-primary transition-colors" style="font-size:12px;color:#007a5a;">
            <i class="fas fa-download" style="font-size:12px;"></i> Télécharger
          </a>
        <?php endif; ?>
        <a href="/ressource/<?= $r->getId() ?>" class="flex items-center gap-1 hover:text-primary transition-colors" style="font-size:12px;color:#007a5a;"><i class="fas fa-comment" style="font-size:12px;"></i> Commenter</a>
      </div>
    </div>
  </div>

</div>
<?php if ($showDivider ?? true): ?>
  <div class="border-b border-border"></div>
<?php endif; ?>