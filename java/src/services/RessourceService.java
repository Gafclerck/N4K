package services;

import entity.Groupe;
import entity.Ressource;
import entity.TypeRessource;
import entity.User;
import java.util.ArrayList;

public class RessourceService {

    private static ArrayList<Ressource> ressources = new ArrayList<>();

    // Constructeur privé — classe utilitaire non instanciable
    private RessourceService() {}

    public static int getNbrRessource() {
        return ressources.size();
    }

    public static ArrayList<Ressource> getRessources() {
        return new ArrayList<>(ressources); // copie défensive
    }

    public static boolean addRessource(Ressource r) {
        ressources.add(r);
        return true;
    }

    public static ArrayList<Ressource> getRessourcesByUser(User user) {
        ArrayList<Ressource> result = new ArrayList<>();
        for (Ressource r : ressources) {
            if (r.getAuteur().getNomUtilisateur().equals(user.getNomUtilisateur())) {
                result.add(r);
            }
        }
        return result;
    }

    public static ArrayList<Ressource> getRessourcesByGroupe(Groupe g) {
        ArrayList<Ressource> result = new ArrayList<>();
        for (Ressource r : ressources) {
            if (r.getGroupe() != null && r.getGroupe().getNom().equals(g.getNom())) {
                result.add(r);
            }
        }
        return result;
    }

    // Filtres de recherche 

    public static ArrayList<Ressource> getRessourceByTitle(ArrayList<Ressource> initial, String titre) {
        ArrayList<Ressource> result = new ArrayList<>();
        for (Ressource r : initial) {
            if (r.getTitre().equalsIgnoreCase(titre)) {
                result.add(r);
            }
        }
        return result;
    }

    public static ArrayList<Ressource> getRessourceByMatiere(ArrayList<Ressource> initial, String nomMatiere) {
        ArrayList<Ressource> result = new ArrayList<>();
        for (Ressource r : initial) {
            if (r.getMatiere().getNom().equalsIgnoreCase(nomMatiere)) {
                result.add(r);
            }
        }
        return result;
    }

    public static ArrayList<Ressource> getRessourceByType(ArrayList<Ressource> initial, TypeRessource type) {
        ArrayList<Ressource> result = new ArrayList<>();
        for (Ressource r : initial) {
            if (r.getType() == type) {
                result.add(r);
            }
        }
        return result;
    }

    public static ArrayList<Ressource> getRessourcesByDate(ArrayList<Ressource> initial, int annee) {
        ArrayList<Ressource> result = new ArrayList<>();
        for (Ressource r : initial) {
            if (r.getDatePartage().getAnnee() == annee) {
                result.add(r);
            }
        }
        return result;
    }
}
