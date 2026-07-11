<?php
require_once "inc/fonctions.php";
?>
<div class="max-w-4xl mx-auto px-4 py-6">
  <a href="/index" class="inline-flex items-center gap-1 text-muted-foreground hover:text-foreground transition-colors mb-4" style="font-size:14px;">
    <i class="fas fa-arrow-left" style="font-size:14px;"></i> Retour
  </a>

  <div class="bg-card border border-border rounded-xl p-6 shadow-sm">
    <h1 class="font-lato text-foreground mb-2" style="font-size:24px;"><?= htmlspecialchars($ressource->getTitre()) ?></h1>
    <div class="flex flex-wrap items-center gap-3 text-muted-foreground mb-4" style="font-size:13px;">
      <span class="flex items-center gap-1">
        <i class="fas fa-user"></i>
        <?= htmlspecialchars($ressource->getAuteur()?->getNom() ?? 'Anonyme') ?>
      </span>
      <?php if ($ressource->getMatiere()): ?>
        <span class="flex items-center gap-1">
          <i class="fas fa-book"></i>
          <?= htmlspecialchars($ressource->getMatiere()->getNom()) ?>
        </span>
      <?php endif; ?>
      <span class="flex items-center gap-1">
        <i class="fas fa-tag"></i>
        <?= $ressource->getType()->value ?>
      </span>
      <?php if ($ressource->getFilepath()): ?>
        <span class="flex items-center gap-1">
          <i class="fas fa-file"></i>
          <?= strtoupper(pathinfo($ressource->getOriginalName() ?? '', PATHINFO_EXTENSION)) ?>
        </span>
        <span class="flex items-center gap-1">
          <i class="fas fa-weight"></i>
          <?= formatFileSize($ressource->getFileSize()) ?>
        </span>
      <?php endif; ?>
    </div>

    <p class="text-foreground mb-6" style="font-size:15px;line-height:1.6;"><?= nl2br(htmlspecialchars($ressource->getDescription())) ?></p>

    <?php if ($ressource->getFilepath()): ?>
      <div class="flex gap-3 mb-6">
        <a href="/ressource/<?= $ressource->getId() ?>/download"
          class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white font-medium hover:opacity-90 transition-opacity"
          style="background-color:#007a5a;font-size:14px;">
          <i class="fas fa-download"></i> Télécharger
        </a>
        <a href="/ressource/<?= $ressource->getId() ?>/view" target="_blank"
          class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-border font-medium text-foreground hover:bg-secondary transition-colors"
          style="font-size:14px;">
          <i class="fas fa-eye"></i> Voir
        </a>
      </div>
    <?php endif; ?>
  </div>

  <div class="mt-8">
    <h2 class="font-lato text-foreground mb-4" style="font-size:20px;">
      <i class="fas fa-comments"></i> Commentaires (<?= count($commentaires) ?>)
    </h2>

    <?php if (\App\config\Session::isConnected()): ?>
      <form action="/ressource/<?= $ressource->getId() ?>/commenter" method="POST" class="mb-6">
        <div class="flex gap-2">
          <input type="text" name="message" required placeholder="Écrire un commentaire…"
            class="flex-1 bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
            style="font-size:14px;">
          <button type="submit" class="px-4 py-2.5 rounded-lg text-white font-medium hover:opacity-90 transition-opacity flex-shrink-0" style="background-color:#007a5a;font-size:14px;">
            <i class="fas fa-paper-plane"></i>
          </button>
        </div>
      </form>
    <?php else: ?>
      <p class="text-muted-foreground mb-6" style="font-size:14px;">
        <a href="/login" class="font-medium" style="color:#007a5a;">Connectez-vous</a> pour commenter.
      </p>
    <?php endif; ?>

    <div class="space-y-3">
      <?php if (empty($commentaires)): ?>
        <p class="text-muted-foreground" style="font-size:14px;">Aucun commentaire pour le moment.</p>
      <?php endif; ?>
      <?php foreach ($commentaires as $c): ?>
        <div class="bg-card border border-border rounded-lg p-4">
          <div class="flex items-center justify-between mb-1">
            <span class="font-medium text-foreground" style="font-size:14px;">
              <?= htmlspecialchars($c->getUser()?->getNom() ?? 'Anonyme') ?>
            </span>
            <span class="text-muted-foreground" style="font-size:12px;"><?= htmlspecialchars($c->getCreatedAt()) ?></span>
          </div>
          <p class="text-foreground" style="font-size:14px;"><?= htmlspecialchars($c->getMessage()) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>