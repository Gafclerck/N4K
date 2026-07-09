<?php
if (!isset($joinGroup)) return;
?>
<div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background-color:rgba(0,0,0,0.35);">
  <div class="bg-white border border-border rounded-xl shadow-xl w-full max-w-md">
    <div class="flex items-center justify-between px-5 py-4 border-b border-border">
      <div>
        <h3 class="font-lato" style="font-size:20px;color:#1d1c1d;">Rejoindre le groupe</h3>
        <p class="text-muted-foreground" style="font-size:13px;"><?= htmlspecialchars($joinGroup->getNom()) ?></p>
      </div>
      <a href="/groupes" class="p-1.5 rounded-md hover:bg-secondary transition-colors" style="color:#616061;">
        <i class="fas fa-times" style="font-size:16px;"></i>
      </a>
    </div>
    <form action="/groupes/join" method="POST" class="px-5 py-4 space-y-4">
      <input type="hidden" name="group_id" value="<?= $joinGroup->getId() ?>">
      <?php if ($joinGroup->getVisibilite() === "Prive"): ?>
        <p class="text-muted-foreground" style="font-size:14px;">
          Ce groupe est <strong class="text-foreground">privé</strong>. Entrez le code d'accès fourni par un administrateur pour rejoindre.
        </p>
      <?php else: ?>
        <p class="text-muted-foreground" style="font-size:14px;">
          Ce groupe est <strong class="text-foreground">public</strong>. Confirmez pour rejoindre automatiquement.
        </p>
      <?php endif; ?>
      <?php if (!empty($joinErrors)): ?>
        <div class="bg-red-50 border border-red-200 rounded-lg px-3 py-2 text-red-700" style="font-size:13px;">
          <?= htmlspecialchars($joinErrors[0]) ?>
        </div>
      <?php endif; ?>
      <?php if ($joinGroup->getVisibilite() === "Prive"): ?>
        <div>
          <label class="block font-medium mb-1.5" style="font-size:14px;">Code d'accès</label>
          <input type="text" name="access_code" required autofocus placeholder="Ex. MATH2024"
            class="w-full bg-input-background border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow font-mono tracking-widest uppercase"
            style="font-size:15px;">
        </div>
      <?php endif; ?>
      <div class="flex gap-2 pt-1">
        <a href="/groupes" class="flex-1 block text-center py-2.5 rounded-lg border border-border font-medium text-muted-foreground hover:bg-secondary transition-colors" style="font-size:14px;">Annuler</a>
        <button type="submit" class="flex-1 py-2.5 rounded-lg text-white font-semibold hover:opacity-90 transition-opacity" style="background-color:#007a5a;font-size:14px;">
          <?= $joinGroup->getVisibilite() === "Prive" ? 'Valider' : 'Rejoindre' ?>
        </button>
      </div>
    </form>
  </div>
</div>