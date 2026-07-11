package services;

import entity.Groupe;
import entity.Membre;
import entity.TypeMembre;
import entity.User;
import utils.Date;
import java.util.ArrayList;

public class GroupeService {

    private static ArrayList<Groupe> groupes = new ArrayList<>();

    // Constructeur privé — classe utilitaire non instanciable
    private GroupeService() {}

    public static int getNbrGroupe() {
        return groupes.size();
    }

    public static ArrayList<Groupe> getGroupes() {
        return new ArrayList<>(groupes); // copie défensive
    }

    // Retourne les groupes dont u est membre
    public static ArrayList<Groupe> getGroupesByUser(User u) {
        ArrayList<Groupe> result = new ArrayList<>();
        for (Groupe g : groupes) {
            if (g.estMembre(u)) {
                result.add(g);
            }
        }
        return result;
    }

    public static boolean addGroupe(Groupe g, User owner) {
        g.setAdmin(owner);
        groupes.add(g);
        g.setCodeGroupe(generateCode(groupes.size(), g));
        // Créer le membre admin
        Date now = g.getDateCreation();
        Membre m = new Membre(now, g, owner);
        m.setTypeMembre(TypeMembre.ADMIN);
        g.addMembre(m);
        return true;
    }

    public static boolean joinGroupe(Groupe g, String code, User u) {
        if (g.getCodeGroupe().equals(code)) {
            Membre m = new Membre(g.getDateCreation(), g, u); // date a remplace par la date actuelle
            m.setTypeMembre(TypeMembre.MEMBRE);
            g.addMembre(m);
            return true;
        }
        return false;
    }

    public static Groupe getGroupeByNom(String nom) {
        for (Groupe g : groupes) {
            if (g.getNom().equals(nom)) {
                return g;
            }
        }
        return null;
    }

    private static String generateCode(int id, Groupe g) {
        return "G" + id + g.getDateCreation().timestamp();
    }
}
