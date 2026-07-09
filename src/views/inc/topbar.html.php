<?php

use App\config\Session;

?>

<header class="h-14 flex items-center gap-3 px-4 border-b border-border bg-background flex-shrink-0">
  <button onclick="document.getElementById('mobileSidebar').classList.toggle('hidden')" class="md:hidden p-1.5 rounded-md hover:bg-secondary transition-colors">
    <i class="fas fa-bars" style="font-size:20px;"></i>
  </button>

  <span class="hidden sm:block text-foreground font-semibold" style="font-size:14px;"> <?php echo (Session::getCurrentUser())->getNom() ?> </span>

  <div class="flex-1 flex items-center gap-2 max-w-sm mx-auto">
    <div class="relative flex-1">
      <i class="fas fa-search absolute" style="font-size:14px;color:#616061;left:10px;top:50%;transform:translateY(-50%);"></i>
      <form action="<?= basename($_SERVER['PHP_SELF']) ?>" method="GET" class="m-0">
        <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="Rechercher ressources, groupes…"
          class="w-full bg-input-background border border-border rounded-lg pl-8 pr-3 py-1.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
          style="font-size:14px;">
      </form>
    </div>
  </div>

  <div class="flex items-center gap-2">
    <?php if ($page !== "publier"): ?>
      <a href="publier" class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-white font-medium transition-opacity hover:opacity-90" style="background-color:#007a5a;font-size:14px;">
        <i class="fas fa-upload" style="font-size:14px;"></i> Publier
      </a>
    <?php endif; ?>
    <button onclick="toggleRecentPanel()" title="Récemment partagés" class="xl:hidden p-1.5 rounded-md hover:bg-secondary transition-colors text-muted-foreground hover:text-foreground">
      <i class="fas fa-chart-line" style="font-size:18px;"></i>
    </button>
    <span class="w-8 h-8 rounded-full flex-shrink-0 flex items-center justify-center text-white font-semibold" style="background-color:#007a5a;font-size:12px;">AD</span>
  </div>
</header>