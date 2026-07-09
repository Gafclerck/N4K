<?php
// modale-creer-groupe.php
// Expected to be included in a page. Shows modal when $showCreateModal is true.

if (!isset($showCreateModal)) $showCreateModal = false;
if (!$showCreateModal) return;

?>
<div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background-color:rgba(0,0,0,0.35);">
    <div class="bg-white border border-border rounded-xl shadow-xl w-full max-w-md">
        <div class="flex items-center justify-between px-5 py-4 border-b border-border">
            <h3 class="font-lato" style="font-size:20px;color:#1d1c1d;">Créer un groupe</h3>
            <a href="?<?= http_build_query(array_merge($_GET, ['modal' => null])) ?>" class="p-1.5 rounded-md hover:bg-secondary transition-colors" style="color:#616061;">
                <i class="fas fa-times" style="font-size:16px;"></i>
            </a>
        </div>
        <form action="/groupes/create" method="POST" class="px-5 py-4 space-y-4">
            <input type="hidden" name="action" value="create_group">
            <div>
                <label class="block font-medium mb-1.5" style="font-size:14px;">Nom du groupe</label>
                <input type="text" name="nom" required placeholder="Ex. Droit Pénal L2"
                    class="w-full bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
                    style="font-size:15px;"
                    value="<?php echo htmlspecialchars($olds['nom'] ?? ''); ?>">
                <small class="text-muted-foreground text-red" style="font-size:12px; color : red;"> <?php echo $errors['nom'] ?? ''; ?></small>
            </div>
            <div>
                <label class="block font-medium mb-1.5" style="font-size:14px;">Description</label>
                <textarea name="description" rows="3" placeholder="Décrivez l'objectif du groupe…"
                    class="w-full bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow resize-none"
                    style="font-size:15px;
                    value=" <?php echo htmlspecialchars($olds['description'] ?? ''); ?>></textarea>
                <small class="text-muted-foreground text-red" style="font-size:12px; color : red;"> <?php echo $errors['description'] ?? ''; ?></small>
            </div>
            <div>
                <label class="block font-medium mb-2" style="font-size:14px;">Type de groupe</label>
                <div class="flex gap-2">
                    <button type="button" onclick="selectType('Public')" id="type-public"
                        class="flex-1 flex items-center justify-center gap-2 py-2 rounded-lg border font-medium transition-colors"
                        style="font-size:14px;border-color:#007a5a;background-color:#f0faf6;color:#007a5a;">
                        <i class="fas fa-globe" style="font-size:14px;"></i> Public <i class="fas fa-check" style="font-size:13px;"></i>
                    </button>
                    <button type="button" onclick="selectType('Prive')" id="type-private"
                        class="flex-1 flex items-center justify-center gap-2 py-2 rounded-lg border font-medium transition-colors"
                        style="font-size:14px;border-color:rgba(0,0,0,0.08);background-color:transparent;color:#8a8a8a;">
                        <i class="fas fa-lock" style="font-size:14px;"></i> Privé
                    </button>
                </div>
                <input type="hidden" name="type" id="group-type-input" value="Public">
                <p id="private-hint" class="mt-2 text-muted-foreground hidden" style="font-size:12px;">
                    Un code d'accès sera généré automatiquement pour ce groupe privé.
                </p>
            </div>
            <div class="flex gap-2 pt-1">
                <a
                    href="/groupes"
                    class="flex-1 block text-center py-2.5 rounded-lg border border-border font-medium text-muted-foreground hover:bg-secondary transition-colors"
                    style="font-size:14px;">Annuler
                </a>
                <button type="submit" class="flex-1 py-2.5 rounded-lg text-white font-semibold hover:opacity-90 transition-opacity"
                    style="background-color:#007a5a;font-size:14px;">Créer le groupe</button>
            </div>
        </form>
    </div>
</div>

<script>
    function selectType(type) {
        document.getElementById('group-type-input').value = type;
        const pub = document.getElementById('type-public');
        const priv = document.getElementById('type-private');
        const hint = document.getElementById('private-hint');
        if (type === 'Public') {
            pub.style.borderColor = '#007a5a';
            pub.style.backgroundColor = '#f0faf6';
            pub.style.color = '#007a5a';
            pub.innerHTML = '<i class="fas fa-globe" style="font-size:14px;"></i> Public <i class="fas fa-check" style="font-size:13px;"></i>';
            priv.style.borderColor = 'rgba(0,0,0,0.08)';
            priv.style.backgroundColor = 'transparent';
            priv.style.color = '#8a8a8a';
            priv.innerHTML = '<i class="fas fa-lock" style="font-size:14px;"></i> Privé';
            hint.classList.add('hidden');
        } else {
            priv.style.borderColor = '#007a5a';
            priv.style.backgroundColor = '#f0faf6';
            priv.style.color = '#007a5a';
            priv.innerHTML = '<i class="fas fa-lock" style="font-size:14px;"></i> Privé <i class="fas fa-check" style="font-size:13px;"></i>';
            pub.style.borderColor = 'rgba(0,0,0,0.08)';
            pub.style.backgroundColor = 'transparent';
            pub.style.color = '#8a8a8a';
            pub.innerHTML = '<i class="fas fa-globe" style="font-size:14px;"></i> Public';
            hint.classList.remove('hidden');
        }
    }
</script>