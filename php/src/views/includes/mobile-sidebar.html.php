<?php
// Mobile sidebar overlay — expects $page, $myGroups
$navItems = [
  ["page" => "index",    "label" => "Accueil",         "icon" => "fa-home"],
  ["page" => "groupes",  "label" => "Groupes",         "icon" => "fa-users"],
  ["page" => "favoris",  "label" => "Mes Favoris",    "icon" => "fa-bookmark"],
  ["page" => "mes-ressources", "label" => "Mes publications", "icon" => "fa-university"],
];
?>
<div id="mobileSidebar" class="fixed inset-0 z-50 hidden md:hidden">
  <div class="absolute inset-0 bg-black/40" onclick="document.getElementById('mobileSidebar').classList.add('hidden')"></div>
  <div class="absolute left-0 top-0 bottom-0 flex flex-col bg-sidebar" style="width:240px;border-right:1px solid var(--color-sidebar-border);">
    <!-- Logo -->
    <div class="px-5 py-5 flex items-center gap-2 flex-shrink-0" style="border-bottom:1px solid var(--color-sidebar-border);">
      <span class="font-bold tracking-tight text-white font-lato" style="font-size:22px;">N4K</span>
      <span style="font-size:11px;color:rgba(255,255,255,0.45);">Network For Knowledge</span>
    </div>
    <div class="flex-1 overflow-y-auto scrollbar-none px-3 py-4" style="scrollbar-width:none;">
      <div class="mb-6">
        <p class="px-2 mb-1 font-semibold uppercase tracking-wider" style="font-size:11px;color:rgba(255,255,255,0.45);">Navigation</p>
        <nav class="space-y-0.5">
          <?php foreach ($navItems as $item):
            $isActive = ($page === $item["page"]);
          ?>
          <a href="/<?= $item["page"] ?>"
            class="w-full flex items-center gap-2.5 px-2 py-2 rounded-md text-left transition-colors duration-150"
            style="font-size:14px;<?= $isActive ? 'background-color:#350d36;color:#ffffff;font-weight:600;' : 'color:#cfc3cf;font-weight:400;' ?>"
            <?= !$isActive ? 'onmouseenter="this.style.backgroundColor=\'#350d36\';this.style.color=\'#ffffff\';" onmouseleave="this.style.backgroundColor=\'transparent\';this.style.color=\'#cfc3cf\';"' : '' ?>>
            <i class="fas <?= $item["icon"] ?>" style="width:16px;text-align:center;"></i>
            <?= $item["label"] ?>
          </a>
          <?php endforeach; ?>
        </nav>
      </div>
      <div>
        <p class="px-2 mb-1 font-semibold uppercase tracking-wider" style="font-size:11px;color:rgba(255,255,255,0.45);">Mes Groupes</p>
        <div class="space-y-0.5">
          <?php foreach ($myGroups as $g): ?>
          <a href="/groupe/<?= $g->getId() ?>" class="w-full flex items-center gap-2.5 px-2 py-1.5 rounded-md text-left transition-colors duration-150 sidebar-hover-bg" style="font-size:14px;color:#cfc3cf;"
            onmouseenter="this.style.backgroundColor='#350d36';this.style.color='#ffffff';"
            onmouseleave="this.style.backgroundColor='transparent';this.style.color='#cfc3cf';">
            <?php $c = groupColor($g->getNom()); $in = initials($g->getNom()); ?>
            <span class="rounded-full flex items-center justify-center flex-shrink-0 font-semibold text-white" style="width:24px;height:24px;background-color:<?= $c ?>;font-size:9px;"><?= $in ?></span>
            <span class="truncate"><?= htmlspecialchars($g->getNom()) ?></span>
          </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
