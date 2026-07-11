package controllers;

import entity.*;
import services.GroupeService;
import services.RessourceService;
import views.GroupeView;
import views.UserView;
import java.util.ArrayList;

public class EtudiantController {

    private EtudiantController() {
    }

    public static void main(User u) {
        int choix;
        do {
            System.out.println("\n========= Menu Étudiant =========");
            System.out.println("1. Créer un groupe");
            System.out.println("2. Intégrer un groupe");
            System.out.println("3. Afficher mes groupes");
            System.out.println("4. Partager une ressource");
            System.out.println("5. Rechercher une ressource");
            System.out.println("6. Voir mes ressources");
            System.out.println("7. Voir toutes les ressources");
            System.out.println("8. Voir les ressources d'un groupe");
            System.out.println("9. Déconnexion");
            System.out.print("Veuillez choisir une option : ");
            while (!UserView.scanner.hasNextInt()) {
                UserView.scanner.next();
            }
            choix = UserView.scanner.nextInt();
            UserView.scanner.nextLine();

            switch (choix) {
                case 1:
                    creerGroupe(u);
                    break;
                case 2:
                    integrerGroupe(u);
                    break;
                case 3:
                    ArrayList<Groupe> mesGroupes3 = GroupeService.getGroupesByUser(u);
                    GroupeView.afficherGroupes(mesGroupes3);
                    break;
                case 4:
                    partagerRessource(u);
                    break;
                case 5:
                    rechercherRessource();
                    break;
                case 6:
                    ArrayList<Ressource> mesRes = RessourceService.getRessourcesByUser(u);
                    GroupeView.afficherRessources(mesRes);
                    break;
                case 7:
                    GroupeView.afficherRessources(RessourceService.getRessources());
                    break;
                case 8:
                    ArrayList<Groupe> mesGroupes8 = GroupeService.getGroupesByUser(u);
                    Groupe g = GroupeView.choisirGroupe(mesGroupes8);
                    GroupeView.afficherRessources(RessourceService.getRessourcesByGroupe(g));
                    break;
                case 9:
                    System.out.println("Déconnexion...");
                    break;
                default:
                    System.out.println("Option invalide. Veuillez réessayer.");
            }
        } while (choix != 9);
    }

    public static void creerGroupe(User u) {
        Groupe g = GroupeView.saisieGroupe();
        if (GroupeService.addGroupe(g, u)) {
            System.out.println("Groupe créé avec succès ! Code d'accès : " + g.getCodeGroupe());
        } else {
            System.out.println("Échec de la création du groupe.");
        }
    }

    public static void integrerGroupe(User u) {
        ArrayList<Groupe> tousGroupes = GroupeService.getGroupes();
        if (tousGroupes.isEmpty()) {
            System.out.println("Aucun groupe disponible.");
            return;
        }
        Groupe g = GroupeView.choisirGroupe(tousGroupes);
        System.out.print("Entrez le code d'accès du groupe : ");
        String code = UserView.scanner.nextLine();
        if (GroupeService.joinGroupe(g, code, u)) {
            System.out.println("Groupe intégré avec succès !");
        } else {
            System.out.println("Code incorrect ou groupe inaccessible.");
        }
    }

    public static void partagerRessource(User u) {
        ArrayList<Groupe> mesGroupes = GroupeService.getGroupesByUser(u);
        if (mesGroupes.isEmpty()) {
            System.out.println("Vous n'appartenez à aucun groupe.");
            return;
        }
        Groupe g = GroupeView.choisirGroupe(mesGroupes);
        if (g.estMembre(u)) {
            Ressource ressource = GroupeView.saisieRessource(u);
            ressource.setGroupe(g);
            RessourceService.addRessource(ressource);
            System.out.println("Ressource partagée avec succès !");
        } else {
            System.out.println("Vous n'êtes pas membre de ce groupe.");
        }
    }

    public static void rechercherRessource() {
        ArrayList<Ressource> tabR = RessourceService.getRessources();
        int choix;
        do {
            System.out.println("\n............. Recherche de Ressources .............");
            System.out.println("1. Par titre");
            System.out.println("2. Par matière");
            System.out.println("3. Par type");
            System.out.println("4. Par date");
            System.out.println("5. Retour au menu principal");
            System.out.print("Veuillez choisir une option : ");
            while (!UserView.scanner.hasNextInt()) {
                UserView.scanner.next();
            }
            choix = UserView.scanner.nextInt();
            UserView.scanner.nextLine();

            switch (choix) {
                case 1:
                    System.out.print("Titre : ");
                    String titre = UserView.scanner.nextLine();
                    GroupeView.afficherRessources(RessourceService.getRessourceByTitle(tabR, titre));
                    break;
                case 2:
                    System.out.print("Nom de la matière : ");
                    String matiere = UserView.scanner.nextLine();
                    GroupeView.afficherRessources(RessourceService.getRessourceByMatiere(tabR, matiere));
                    break;
                case 3:
                    TypeRessource type = GroupeView.selectTypeRessource();
                    GroupeView.afficherRessources(RessourceService.getRessourceByType(tabR, type));
                    break;
                case 4:
                    System.out.print("Année : ");
                    while (!UserView.scanner.hasNextInt()) {
                        UserView.scanner.next();
                    }
                    int annee = UserView.scanner.nextInt();
                    UserView.scanner.nextLine();
                    GroupeView.afficherRessources(RessourceService.getRessourcesByDate(tabR, annee));
                    break;
                case 5:
                    break;
                default:
                    System.out.println("Option invalide.");
            }
        } while (choix != 5);
    }
}
