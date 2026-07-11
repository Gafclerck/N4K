package controllers;

import entity.User;
import services.UserService;
import views.UserView;

public class AuthController {

    private static User currentUser;

    private AuthController() {
    }

    public static User getCurrentUser() {
        return currentUser;
    }

    public static boolean login() {
        System.out.println("=== Connexion ===");
        System.out.print("Nom d'utilisateur : ");
        String nu = UserView.scanner.nextLine();
        System.out.print("Mot de passe : ");
        String mdp = UserView.scanner.nextLine();

        User[] result = new User[1]; // équivalent D/R algo
        if (UserService.login(nu, mdp, result)) {
            currentUser = result[0];
            System.out.println(
                    "Connexion réussie ! Bienvenue, " + currentUser.getPrenom() + " " + currentUser.getNom() + ".");
            return true;
        } else {
            System.out.println("Échec de la connexion. Veuillez vérifier vos informations.");
            return false;
        }
    }

    public static void register() {
        User u = UserView.saisieUser();
        if (UserService.addUser(u)) {
            System.out.println("Inscription réussie ! Vous pouvez maintenant vous connecter.");
        } else {
            System.out.println("Échec de l'inscription. Veuillez réessayer.");
        }
    }
}
