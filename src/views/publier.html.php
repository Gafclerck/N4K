<?php
$page = "publier";
$pageTitle = "Publier — N4K";
require_once "inc/fonctions.php";

$resources_types = $GLOBALS["RESOURCE_TYPES"];
$showVisibility = $showVisibility ?? false;
$groupId = $groupId ?? null;
$formAction = $formAction ?? "/publier";
$matieres = $matieres ?? [];

?>

<div class="flex h-screen overflow-hidden bg-background">
  <?php include "inc/sidebar.html.php"; ?>

  <div class="flex-1 flex flex-col min-w-0 overflow-hidden" style="width:0;">
    <?php include "inc/topbar.html.php"; ?>

    <div class="flex-1 overflow-y-auto p-4 md:p-6">
      <?php include "includes/form-publier.html.php"; ?>
    </div>
  </div>
</div>

<?php include "includes/mobile-sidebar.html.php"; ?>
