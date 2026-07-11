<?php $page = "register";
$pageTitle = "Inscription N4K"; ?>

<div class="min-h-screen bg-background flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <h1 class="mb-1 font-lato" style="font-size:36px;color:#007a5a;">N4K</h1>
            <p class="text-muted-foreground" style="font-size:14px;">Créer un compte</p>
        </div>
        <form class="bg-card border border-border rounded-xl p-6 shadow-sm space-y-4"
            method="POST" action="/register">
            <div>
                <label class="block text-foreground font-medium mb-1.5" style="font-size:14px;">Nom complet</label>
                <input type="text" placeholder="Amadou Gafar"
                    class="w-full bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
                    style="font-size:16px;"
                    name="nom"
                    value="<?php echo htmlspecialchars($olds['nom'] ?? ''); ?>">
                <small class="text-muted-foreground text-red" style="font-size:12px; color : red"><?php echo $errors['nom'] ?? ''; ?></small>
            </div>
            <div>
                <label class="block text-foreground font-medium mb-1.5" style="font-size:14px;">Adresse email</label>
                <input type="email" placeholder="vous@exemple.com"
                    class="w-full bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
                    style="font-size:16px;"
                    name="email"
                    value="<?php echo htmlspecialchars($olds['email'] ?? ''); ?>">
                <small class="text-muted-foreground text-red" style="font-size:12px; color : red;"> <?php echo $errors['email'] ?? ''; ?></small>
            </div>
            <div>
                <label class="block text-foreground font-medium mb-1.5" style="font-size:14px;">Nom Utilisateur</label>
                <input type="text" placeholder="clerck"
                    class="w-full bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
                    name="username"
                    style="font-size:16px;"
                    value="<?php echo htmlspecialchars($olds['username'] ?? ''); ?>">
                <small class="text-muted-foreground text-red" style="font-size:12px; color : red;"><?php echo $errors['username'] ?? ''; ?></small>
            </div>
            <div>
                <label class="block text-foreground font-medium mb-1.5" style="font-size:14px;">Mot de passe</label>
                <input type="password" placeholder="••••••••"
                    class="w-full bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
                    name="password"
                    style="font-size:16px;"
                    value="<?php echo htmlspecialchars($olds['password'] ?? ''); ?>">
                <small class="text-muted-foreground text-red" style="font-size:12px; color : red;"><?php echo $errors['password'] ?? ''; ?></small>
            </div>
            <button type="submit" class="block w-full text-center py-2.5 rounded-lg text-white font-semibold hover:opacity-90 transition-opacity" style="background-color:#007a5a;font-size:16px;">Créer un compte</button>
            <p class="text-center text-muted-foreground" style="font-size:14px;">
                Déjà inscrit ?
                <a href="/login" class="font-medium hover:opacity-80 transition-opacity" style="color:#007a5a;">Se connecter</a>
            </p>
        </form>
    </div>
</div>