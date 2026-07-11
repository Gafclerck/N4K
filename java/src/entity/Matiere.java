package entity;

public class Matiere {

    private String nom;
    private String description;

    public Matiere(String nom, String description) {
        this.nom = nom;
        this.description = description;
    }

    // Getters
    public String getNom() { return nom; }
    public String getDescription() { return description; }

    @Override
    public String toString() {
        return nom + " (" + description + ")";
    }
}
