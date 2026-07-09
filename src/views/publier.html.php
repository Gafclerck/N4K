<?php
$page = "publier";
$pageTitle = "Publier — N4K";
require_once "inc/fonctions.php";

$resources_types = $GLOBALS["RESOURCE_TYPES"];
$myGroupIds = getMyGroupIds();
$myGroups = array_filter($GLOBALS["INITIAL_GROUPS"], fn($g) => in_array($g->getId(), $myGroupIds));

?>

<div class="flex h-screen overflow-hidden bg-background">
  <?php include "inc/sidebar.html.php"; ?>

  <div class="flex-1 flex flex-col min-w-0 overflow-hidden" style="width:0;">
    <?php include "inc/topbar.html.php"; ?>

    <div class="flex-1 overflow-y-auto p-4 md:p-6">
      <div class="max-w-2xl mx-auto">
        <h2 class="text-foreground mb-6 font-lato" style="font-size:26px;">Publier une ressource</h2>
        <form action="publier.html.php" method="POST" enctype="multipart/form-data" class="space-y-5">
          <div>
            <label class="block text-foreground font-medium mb-1.5" style="font-size:14px;">Titre</label>
            <input type="text" name="title" required placeholder="Ex. Cours d'Algèbre Linéaire — Chapitre 3"
              class="w-full bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
              style="font-size:16px;">
          </div>
          <div>
            <label class="block text-foreground font-medium mb-1.5" style="font-size:14px;">Description</label>
            <textarea name="description" rows="4" placeholder="Décrivez brièvement la ressource…"
              class="w-full bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow resize-none"
              style="font-size:16px;"></textarea>
          </div>
          <div>
            <label class="block text-foreground font-medium mb-1.5" style="font-size:14px;">Matière / Mots-clés</label>
            <input type="text" name="keywords" placeholder="Mathématiques, algèbre, matrices…"
              class="w-full bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
              style="font-size:16px;">
          </div>
          <div>
            <label class="block text-foreground font-medium mb-1.5" style="font-size:14px;">Type de ressource</label>
            <select name="type"
              class="w-full bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
              style="font-size:16px;">
              <option value="">Sélectionner un type…</option>
              <?php foreach ($resources_types as $t): ?>
                <option value="<?= $t ?>"><?= $t ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label class="block text-foreground font-medium mb-1.5" style="font-size:14px;">Fichier</label>
            <label id="fileDropzone"
              class="flex flex-col items-center justify-center gap-2 border-2 border-dashed rounded-xl py-8 cursor-pointer transition-colors"
              style="border-color:#ecb22e;background-color:#f8fff9;">
              <i class="fas fa-upload" style="font-size:24px;color:#ecb22e;"></i>
              <span id="fileLabel" class="text-foreground font-medium" style="font-size:14px;">Glissez votre fichier ici</span>
              <span class="text-muted-foreground" style="font-size:12px;">ou cliquez pour parcourir</span>
              <input type="file" name="file" id="fileInput" class="sr-only" style="display:none;">
            </label>
          </div>
          <div>
            <label class="block text-foreground font-medium mb-2" style="font-size:14px;">Visibilité</label>
            <div class="flex gap-3">
              <button type="button" onclick="selectVisibility('public')" id="vis-public"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border font-medium transition-colors"
                style="font-size:14px;border-color:#007a5a;background-color:#f0faf6;color:#007a5a;">
                <i class="fas fa-globe" style="font-size:14px;"></i> Publique <i class="fas fa-check" style="font-size:13px;"></i>
              </button>
              <button type="button" onclick="selectVisibility('private')" id="vis-private"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border font-medium transition-colors"
                style="font-size:14px;border-color:rgba(0,0,0,0.08);background-color:transparent;color:#8a8a8a;">
                <i class="fas fa-lock" style="font-size:14px;"></i> Privée
              </button>
            </div>
            <input type="hidden" name="visibility" id="visibility-input" value="public">
            <div id="group-select-wrapper" class="mt-2 hidden">
              <select name="group_id"
                class="w-full bg-input-background border border-border rounded-lg px-3 py-2 text-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
                style="font-size:14px;">
                <option value="">Sélectionner un groupe…</option>
                <?php foreach ($myGroups as $g): ?>
                  <option value="<?= $g->getId() ?>"><?= htmlspecialchars($g->getNom()) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <button type="submit" class="w-full py-3 rounded-lg text-white font-semibold hover:opacity-90 transition-opacity flex items-center justify-center gap-2" style="background-color:#007a5a;font-size:16px;">
            <i class="fas fa-upload" style="font-size:18px;"></i> Partager la ressource
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function selectVisibility(type) {
    document.getElementById('visibility-input').value = type;
    const pub = document.getElementById('vis-public');
    const priv = document.getElementById('vis-private');
    const grp = document.getElementById('group-select-wrapper');
    if (type === 'public') {
      pub.style.borderColor = '#007a5a';
      pub.style.backgroundColor = '#f0faf6';
      pub.style.color = '#007a5a';
      pub.innerHTML = '<i class="fas fa-globe" style="font-size:14px;"></i> Publique <i class="fas fa-check" style="font-size:13px;"></i>';
      priv.style.borderColor = 'rgba(0,0,0,0.08)';
      priv.style.backgroundColor = 'transparent';
      priv.style.color = '#8a8a8a';
      priv.innerHTML = '<i class="fas fa-lock" style="font-size:14px;"></i> Privée';
      grp.classList.add('hidden');
    } else {
      priv.style.borderColor = '#007a5a';
      priv.style.backgroundColor = '#f0faf6';
      priv.style.color = '#007a5a';
      priv.innerHTML = '<i class="fas fa-lock" style="font-size:14px;"></i> Privée <i class="fas fa-check" style="font-size:13px;"></i>';
      pub.style.borderColor = 'rgba(0,0,0,0.08)';
      pub.style.backgroundColor = 'transparent';
      pub.style.color = '#8a8a8a';
      pub.innerHTML = '<i class="fas fa-globe" style="font-size:14px;"></i> Publique';
      grp.classList.remove('hidden');
    }
  }

  const dropzone = document.getElementById('fileDropzone');
  const fileInput = document.getElementById('fileInput');
  const fileLabel = document.getElementById('fileLabel');

  dropzone.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.style.borderColor = '#007a5a';
    this.style.backgroundColor = '#f0faf6';
  });
  dropzone.addEventListener('dragleave', function() {
    this.style.borderColor = '#ecb22e';
    this.style.backgroundColor = '#f8fff9';
  });
  dropzone.addEventListener('drop', function(e) {
    e.preventDefault();
    this.style.borderColor = '#ecb22e';
    this.style.backgroundColor = '#f8fff9';
    if (e.dataTransfer.files[0]) {
      fileLabel.textContent = e.dataTransfer.files[0].name;
      fileInput.files = e.dataTransfer.files;
    }
  });
  dropzone.addEventListener('click', function() {
    fileInput.click();
  });
  fileInput.addEventListener('change', function() {
    if (this.files[0]) fileLabel.textContent = this.files[0].name;
  });
</script>

<?php include "includes/mobile-sidebar.html.php"; ?>
