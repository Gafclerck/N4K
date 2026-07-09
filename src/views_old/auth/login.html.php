<div class="min-h-screen bg-background flex items-center justify-center p-4">
    <form method="POST" action="/login" class="w-full max-w-sm">
        <div class="text-center mb-8">
            <h1 class="mb-1" style="font-family: 'DM Serif Display', serif; font-size: 36; color: #007a5a;">
                N4K
            </h1>
            <p class="text-muted-foreground" style="font-size: 14;">Network For Know ledge</p>
        </div>
        <div class="bg-card border border-border rounded-xl p-6 shadow-sm space-y-4">
            <div>
                <label class="block text-foreground font-medium mb-1.5" style="font-size: 14;">Username</label>
                <input type="text" placeholder="Votre nom d'utilisateur"
                    class="w-full bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
                    style="font-size: 16;"
                    name="username" />
            </div>
            <div>
                <label class="block text-foreground font-medium mb-1.5" style="font-size: 14;">Mot de passe</label>
                <input type="password" placeholder="••••••••"
                    class="w-full bg-input-background border border-border rounded-lg px-3 py-2.5 text-foreground placeholder:text-muted-foreground outline-none focus:ring-2 focus:ring-primary/30 transition-shadow"
                    style="font-size: 16;"
                    name="password" />
            </div>
            <button
                type="submit"
                class="w-full py-2.5 rounded-lg text-white font-semibold hover:opacity-90 transition-opacity cursor-pointer"
                style="background-color: #007a5a; font-size: 16; ">
                Se connecter
            </button>
            <div class="flex items-center justify-between pt-1" style="font-size: 14;">
                <button class="text-muted-foreground hover:text-primary transition-colors cursor-pointer">pas encore de compte ?</button>
                <a href="/register" class="font-medium hover:opacity-80 transition-opacity" style="color: #007a5a;">
                    Créer un compte
                </a>
            </div>
        </div>
    </form>
</div>