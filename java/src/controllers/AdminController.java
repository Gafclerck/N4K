package controllers;

import entity.Groupe;
import entity.Ressource;
import entity.User;
import services.GroupeService;
import services.RessourceService;
import services.UserService;
import views.GroupeView;
import views.UserView;
import java.util.ArrayList;

public class AdminController {

    private AdminController() {}

    public static void main(User u) {
        int choix;
        do {
            System.out.println("\n========= Menu Administrateur =========");
            System.out.println("1. Voir tous les utilisateurs");
            System.out.println("2. Voir tous les groupes");
            System.out.println("3. Voir toutes les ressources");
            System.out.println("4. Déconnexion");
            System.out.print("Veuillez choisir une option : ");
            while (!UserView.scanner.hasNextInt()) { UserView.scanner.next(); }
            choix = UserView.scanner.nextInt();
            UserView.scanner.nextLine();

            switch (choix) {
                case 1:
                    UserView.afficherUsers(UserService.getUsers());
                    break;
                case 2:
                    GroupeView.afficherGroupes(GroupeService.getGroupes());
                    break;
                case 3:
                    GroupeView.afficherRessources(RessourceService.getRessources());
                    break;
                case 4:
                    System.out.println("Déconnexion...");
                    break;
                default:
                    System.out.println("Option invalide.");
            }
        } while (choix != 4);
    }
}
