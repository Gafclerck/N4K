package views;

import entity.User;
import java.util.ArrayList;

import javax.swing.text.View;

public class UserView extends View {
    private UserView() {
    }

    public static int mainMenu() {
        int choix;
        System.out.println("=== Menu Principal ===");
        System.out.println("1. Se connecter");
        System.out.println("2. S'inscrire");
        System.out.println("3. Quitter");
        do {
            System.out.print("Veuillez entrer votre choix : ");
            while (!scanner.hasNextInt()) {
                System.out.print("Entier attendu : ");
                scanner.next();
            }
            choix = scanner.nextInt();
            scanner.nextLine();
            if (choix < 1 || choix > 3) {
                System.out.println("Choix invalide. Veuillez réessayer.");
            }
        } while (choix < 1 || choix > 3);
        return choix;
    }

    public static User saisieUser() {
        System.out.println("=== Inscription ===");
        System.out.print("Nom : ");
        String nom = scanner.nextLine();
        System.out.print("Prénom : ");
        String prenom = scanner.nextLine();
        System.out.print("Nom d'utilisateur : ");
        String nomUtilisateur = scanner.nextLine();
        System.out.print("Mot de passe : ");
        String mdp = scanner.nextLine();
        System.out.print("Numéro de téléphone : ");
        String tel = scanner.nextLine();
        return new User(nom, prenom, nomUtilisateur, mdp, tel);
    }

    public static void afficherUsers(ArrayList<User> users) {
        System.out.println("=== Liste des utilisateurs ===");
        for (int i = 0; i < users.size(); i++) {
            System.out.println((i + 1) + ". " + users.get(i).toString());
        }
    }
}
