package services;

import entity.User;
import java.util.ArrayList;

public class UserService {

    private static ArrayList<User> users = new ArrayList<>();

    // Constructeur privé — classe utilitaire non instanciable
    private UserService() {}

    public static int getNbrUser() {
        return users.size();
    }

    public static ArrayList<User> getUsers() {
        return new ArrayList<>(users); // copie défensive
    }

    public static boolean addUser(User u) {
        users.add(u);
        return true;
    }

    public static User getUserByNomUtilisateur(String nomUtilisateur) {
        for (User u : users) {
            if (u.getNomUtilisateur().equals(nomUtilisateur)) {
                return u;
            }
        }
        return null;
    }

    public static boolean login(String nomUtilisateur, String mdp, User[] result) {
        User u = getUserByNomUtilisateur(nomUtilisateur);
        if (u == null) {
            System.out.println("Utilisateur non trouvé.");
            return false;
        }
        if (!u.getMdp().equals(mdp)) {
            System.out.println("Mot de passe incorrect.");
            return false;
        }
        result[0] = u; // résultat sortant via tableau à 1 élément (équivalent D/R)
        return true;
    }
}
