<?php

$filter = $filter ?? 'all';
$search = $search ?? '';
$filtered = $filtered ?? $groupes ?? [];
$showCreateModal = ($showCreateModal ?? false) === true;
$joinGroup = $joinGroup ?? null;
$joinErrors = $joinErrors ?? [];

?>

<div class="flex h-screen overflow-hidden bg-background">
    <?php include "inc/sidebar.html.php"; ?>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden" style="width:0;">
        <?php include "inc/topbar.html.php"; ?>

        <?php include "includes/modale-creer-groupe.html.php"; ?>
        <?php include "includes/modale-rejoindre.html.php"; ?>

        <div class="flex-1 overflow-y-auto p-4 md:p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-foreground font-lato" style="font-size:26px;">Groupes &amp; Communautés</h2>
                <a href="?modal=create" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-white font-medium hover:opacity-90 transition-opacity" style="background-color:#007a5a;font-size:14px;">
                    <i class="fas fa-plus" style="font-size:14px;"></i> Créer un groupe
                </a>
            </div>

            <div class="flex flex-wrap items-center gap-2 mb-6">
                <div class="flex rounded-lg border border-border overflow-hidden">
                    <a href="?filter=all" class="px-3 py-1.5 font-medium transition-colors" style="font-size:14px;<?= $filter === 'all' ? 'background-color:#007a5a;color:#ffffff;' : 'background-color:transparent;color:#8a8a8a;' ?>">Tous</a>
                    <a href="?filter=Public" class="px-3 py-1.5 font-medium transition-colors" style="font-size:14px;<?= $filter === 'Public' ? 'background-color:#007a5a;color:#ffffff;' : 'background-color:transparent;color:#8a8a8a;' ?>">Public</a>
                    <a href="?filter=Prive" class="px-3 py-1.5 font-medium transition-colors" style="font-size:14px;<?= $filter === 'Prive' ? 'background-color:#007a5a;color:#ffffff;' : 'background-color:transparent;color:#8a8a8a;' ?>">Privé</a>
                </div>
                <div class="relative flex-1 min-w-40">
                    <i class="fas fa-search absolute" style="font-size:14px;color:#616061;left:10px;top:50%;transform:translateY(-50%);"></i>
                    <form method="GET" class="m-0">
                        <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Recercher un group"
                            class="w-full bg-input-background border border-border rounded-lg pl-8 pr-3 py-1.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
                            style="font-size:14px;">
                    </form>
                </div>
            </div>

            <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <?php foreach ($filtered as $g):
                    $c = groupColor($g->getNom());
                    $in = initials($g->getNom());
                ?>
                    <div class="bg-card border border-border rounded-xl overflow-hidden hover:shadow-md transition-shadow duration-150">
                        <a href="/groupe/<?= $g->getId() ?>">
                            <div class="h-20 flex items-center justify-center" style="background-color:<?= $c ?>;">
                                <span class="text-white font-bold font-lato" style="font-size:28px;"><?= $in ?></span>
                            </div>
                        </a>
                        <div class="p-3">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <p class="text-foreground font-semibold leading-snug" style="font-size:14px;"><?= htmlspecialchars($g->getNom()) ?></p>
                                <span class="flex items-center gap-1 text-muted-foreground flex-shrink-0" style="font-size:11px;">
                                    <?php if ($g->getVisibilite() === "Prive"): ?>
                                        <i class="fas fa-lock" style="font-size:11px;"></i> Privé
                                    <?php else: ?>
                                        <i class="fas fa-globe" style="font-size:11px;"></i> Public
                                    <?php endif; ?>
                                </span>
                            </div>
                            <p class="text-muted-foreground mb-3" style="font-size:12px;"><?= $g->getNbrMembres() ?> membre<?= $g->getNbrMembres() !== 1 ? 's' : '' ?></p>
                            <?php if ($g->isMember()): ?>
                                <span class="block w-full text-center py-1.5 rounded-lg font-medium" style="font-size:13px;background-color:#f2f2f2;color:#007a5a;">
                                    <i class="fas fa-user-check" style="font-size:13px;"></i> Membre
                                </span>
                            <?php elseif ($g->getVisibilite() === "Prive"): ?>
                                <a href="?join=<?= $g->getId() ?>" class="block w-full text-center py-1.5 rounded-lg font-medium transition-opacity hover:opacity-90"
                                    style="font-size:13px;background-color:#007a5a;color:#ffffff;">
                                    <i class="fas fa-lock" style="font-size:12px;"></i> Rejoindre
                                </a>
                            <?php else: ?>
                                <a href="?join=<?= $g->getId() ?>" class="block w-full text-center py-1.5 rounded-lg font-medium transition-opacity hover:opacity-90"
                                    style="font-size:13px;background-color:#007a5a;color:#ffffff;">
                                    Rejoindre
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include "includes/mobile-sidebar.html.php"; ?>