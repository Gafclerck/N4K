package entity;

public class User {
    private String nom;
    private String prenom;
    private String nomUtilisateur;
    private String mdp;
    private String tel;
    private UserRole role;

    public User() {
    }

    public User(String nom, String prenom, String nomUtilisateur, String mdp, String tel) {
        this.nom = nom;
        this.prenom = prenom;
        this.nomUtilisateur = nomUtilisateur;
        this.mdp = mdp;
        this.tel = tel;
        this.role = UserRole.ETUDIANT;
    }

    // Getters
    public String getNom() {
        return nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public String getNomUtilisateur() {
        return nomUtilisateur;
    }

    public String getMdp() {
        return mdp;
    }

    public String getTel() {
        return tel;
    }

    public UserRole getRole() {
        return role;
    }

    // Setters
    public void setNom(String nom) {
        this.nom = nom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }

    public void setNomUtilisateur(String nomUtilisateur) {
        this.nomUtilisateur = nomUtilisateur;
    }

    public void setMdp(String mdp) {
        this.mdp = mdp;
    }

    public void setTel(String tel) {
        this.tel = tel;
    }

    public void setRole(UserRole role) {
        this.role = role;
    }

    @Override
    public String toString() {
        return "Nom : " + nom + "\n" + " | Prénom : " + prenom + "\n" +
                " | Nom d'utilisateur : " + nomUtilisateur + "\n" +
                " | Téléphone : " + tel + "\n" +
                " | Rôle : " + role;
    }
}
