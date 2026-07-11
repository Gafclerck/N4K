package controllers;

import entity.UserRole;
import views.UserView;

public class MainController {

    private MainController() {}

    public static void main() {
        int choix;
        do {
            choix = UserView.mainMenu();
            switch (choix) {
                case 1:
                    if (AuthController.login()) {
                        if (AuthController.getCurrentUser().getRole() == UserRole.ADMIN) {
                            AdminController.main(AuthController.getCurrentUser());
                        } else {
                            EtudiantController.main(AuthController.getCurrentUser());
                        }
                    }
                    break;
                case 2:
                    AuthController.register();
                    break;
                case 3:
                    System.out.println("Au revoir !");
                    break;
                default:
                    System.out.println("Option invalide.");
            }
        } while (choix != 3);
    }
}
