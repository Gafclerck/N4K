<?php $page = "login";
$pageTitle = "Connexion  N4K"; ?>


<div class="min-h-screen bg-background flex items-center justify-center p-4">
  <div class="w-full max-w-sm">
    <div class="text-center mb-8">
      <h1 class="mb-1 font-lato" style="font-size:36px;color:#007a5a;">N4K</h1>
      <p class="text-muted-foreground" style="font-size:14px;">Network For Knowledge</p>
    </div>
    <form method="POST" action="/login"
      class="bg-card border border-border rounded-xl p-6 shadow-sm space-y-4">
      <div>
        <?php if (isset($erros["invalid"])) : ?>
          <div
            class="w-full border border-border border-red rounded-lg px-3 py-2.5 text-muted-foreground"
            style="color : red; font-size: 16px;">Email or password invalid</div>
        <?php endif ?>
        <label class="block text-foreground font-medium mb-1.5" style="font-size:14px;">Username</label>
        <input
          type="text" placeholder="username"
          name="username"
          class="w-full bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
          style="font-size:16px;">
        <small class="text-muted-foreground text-red" style="font-size:12px; color : red;"> <?php echo $errors['username'] ?? ''; ?></small>
      </div>
      <div>
        <label class="block text-foreground font-medium mb-1.5" style="font-size:14px;">Mot de passe</label>
        <input type="password"
          placeholder="••••••••"
          name="password"
          class="w-full bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
          style="font-size:16px;">
        <small class="text-muted-foreground text-red" style="font-size:12px; color : red;"> <?php echo $errors['password'] ?? ''; ?></small>
      </div>
      <button type="submit"
        class="block w-full text-center py-2.5 rounded-lg text-white font-semibold hover:opacity-90 transition-opacity"
        style="background-color:#007a5a;font-size:16px;">Se connecter</button>
      <div class="flex items-center justify-between pt-1" style="font-size:14px;">
        <a href="#" class="text-muted-foreground hover:text-primary transition-colors">Mot de passe oublié ?</a>
        <a href="/register" class="font-medium hover:opacity-80 transition-opacity" style="color:#007a5a;">Créer un compte</a>
      </div>
    </form>
  </div>
</div>