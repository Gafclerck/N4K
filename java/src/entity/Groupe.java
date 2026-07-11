package entity;

import utils.Date;
import java.util.ArrayList;

public class Groupe {
    private String nom;
    private String description;
    private Date dateCreation;
    private User admin;
    private String codeGroupe;
    private ArrayList<Membre> membres;
    private Visibilite visibilite;

    public Groupe(String nom, String description, Date dateCreation) {
        this.nom = nom;
        this.description = description;
        this.dateCreation = dateCreation;
        this.membres = new ArrayList<>();
    }

    public Groupe(String nom, String description, Date dateCreation, User admin, String codeGroupe) {
        this(nom, description, dateCreation);
        this.admin = admin;
        this.codeGroupe = codeGroupe;
    }

    // Getters
    public String getNom() {
        return nom;
    }

    public String getDescription() {
        return description;
    }

    public Date getDateCreation() {
        return dateCreation;
    }

    public User getAdmin() {
        return admin;
    }

    public String getCodeGroupe() {
        return codeGroupe;
    }

    public ArrayList<Membre> getMembres() {
        return membres;
    }

    public int getNbrMembre() {
        return membres.size();
    }

    public Visibilite getVisibilite() {
        return visibilite;
    }

    // Setters
    public void setNom(String nom) {
        this.nom = nom;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public void setDateCreation(Date dateCreation) {
        this.dateCreation = dateCreation;
    }

    public void setAdmin(User admin) {
        this.admin = admin;
    }

    public void setCodeGroupe(String codeGroupe) {
        this.codeGroupe = codeGroupe;
    }

    public void setVisibilite(Visibilite visibilite) {
        this.visibilite = visibilite;
    }

    public void addMembre(Membre m) {
        m.setGroupe(this);
        membres.add(m);
    }

    public boolean estMembre(User u) {
        for (Membre m : membres) {
            if (m.getUser().getNomUtilisateur().equals(u.getNomUtilisateur())) {
                return true;
            }
        }
        return false;
    }

    @Override
    public String toString() {
        return "Nom=" + nom + ", Description=" + description +
                ", DateCreation=" + dateCreation.toString() +
                ", Admin=" + (admin != null ? admin.getNom() : "N/A") + "}";
    }
}
