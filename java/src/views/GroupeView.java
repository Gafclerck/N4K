package views;

import entity.*;
import utils.Date;
import java.util.ArrayList;

public class GroupeView extends View {

    private GroupeView() {
    }

    public static Groupe saisieGroupe() {
        System.out.println("=== Création d'un groupe ===");
        System.out.print("Nom du groupe : ");
        String nom = scanner.nextLine();
        System.out.print("Description du groupe : ");
        String description = scanner.nextLine();
        Visibilite visibilite = selectVisibilite();
        Date dateCreation = saisieDate();
        Groupe g = new Groupe(nom, description, dateCreation);
        g.setVisibilite(visibilite);
        // La visibilite pourra être utilisée pour filtrage futur
        return g;
    }

    public static Visibilite selectVisibilite() {
        int choix;
        System.out.println("Visibilité : 1. Public  2. Privé");
        do {
            System.out.print("Choix : ");
            while (!scanner.hasNextInt()) {
                scanner.next();
            }
            choix = scanner.nextInt();
            scanner.nextLine();
        } while (choix < 1 || choix > 2);
        return choix == 1 ? Visibilite.PUBLIC : Visibilite.PRIVE;
    }

    public static void afficherGroupes(ArrayList<Groupe> groupes) {
        System.out.println("=== Liste des groupes ===");
        for (int i = 0; i < groupes.size(); i++) {
            System.out.println((i + 1) + ". " + groupes.get(i).toString());
        }
    }

    public static Groupe choisirGroupe(ArrayList<Groupe> groupes) {
        afficherGroupes(groupes);
        int choix;
        do {
            System.out.print("Choisissez un numéro : ");
            while (!scanner.hasNextInt()) {
                scanner.next();
            }
            choix = scanner.nextInt();
            scanner.nextLine();
            if (choix < 1 || choix > groupes.size()) {
                System.out.println("Numéro invalide. Veuillez réessayer.");
            }
        } while (choix < 1 || choix > groupes.size());
        return groupes.get(choix - 1);
    }

    public static Ressource saisieRessource(User auteur) {
        System.out.println("=== Création d'une ressource ===");
        System.out.print("Titre : ");
        String titre = scanner.nextLine();
        System.out.print("Description : ");
        String description = scanner.nextLine();
        Matiere matiere = selectMatiere();
        Date date = saisieDate();
        Visibilite visibilite = selectVisibilite();
        TypeRessource type = selectTypeRessource();
        Ressource r = new Ressource(titre, description, date, matiere, type, auteur);
        r.setVisibilite(visibilite);
        return r;
    }

    public static Matiere selectMatiere() {
        System.out.print("Nom de la matière : ");
        String nom = scanner.nextLine();
        System.out.print("Description de la matière : ");
        String desc = scanner.nextLine();
        return new Matiere(nom, desc);
    }

    public static TypeRessource selectTypeRessource() {
        System.out.println("Type de ressource :");
        System.out.println("1. Cours  2. Exercice  3. TD  4. TP  5. Rapport  6. Autre");
        int choix;
        do {
            System.out.print("Choix : ");
            while (!scanner.hasNextInt()) {
                scanner.next();
            }
            choix = scanner.nextInt();
            scanner.nextLine();
        } while (choix < 1 || choix > 6);
        switch (choix) {
            case 1:
                return TypeRessource.COURS;
            case 2:
                return TypeRessource.EXO;
            case 3:
                return TypeRessource.TD;
            case 4:
                return TypeRessource.TP;
            case 5:
                return TypeRessource.RAPPORT;
            default:
                return TypeRessource.AUTRE;
        }
    }

    public static void afficherRessources(ArrayList<Ressource> ressources) {
        System.out.println("=== Liste des ressources ===");
        if (ressources.isEmpty()) {
            System.out.println("Aucune ressource trouvée.");
            return;
        }
        for (int i = 0; i < ressources.size(); i++) {
            System.out.println((i + 1) + ". " + ressources.get(i).toString());
        }
    }

    public static Date saisieDate() {
        System.out.println("Date (jour mois année) :");
        System.out.print("Jour : ");
        while (!scanner.hasNextInt()) {
            scanner.next();
        }
        int j = scanner.nextInt();
        System.out.print("Mois : ");
        while (!scanner.hasNextInt()) {
            scanner.next();
        }
        int m = scanner.nextInt();
        System.out.print("Année : ");
        while (!scanner.hasNextInt()) {
            scanner.next();
        }
        int a = scanner.nextInt();
        scanner.nextLine();
        return new Date(j, m, a);
    }
}
