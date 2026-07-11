package entity;

import utils.Date;
import java.util.ArrayList;

public class Ressource {
    private String titre;
    private String description;
    private Date datePartage;
    private Matiere matiere;
    private TypeRessource typeR;
    private Visibilite visibilite;
    private Groupe groupe;
    private User auteur;
    private ArrayList<Commentaire> commentaires;

    public Ressource(String titre, String description, Date datePartage, Matiere matiere, TypeRessource typeR,
            User auteur) {
        this.titre = titre;
        this.description = description;
        this.datePartage = datePartage;
        this.matiere = matiere;
        this.typeR = typeR;
        this.auteur = auteur;
        this.commentaires = new ArrayList<>();
    }

    // Getters
    public String getTitre() {
        return titre;
    }

    public String getDescription() {
        return description;
    }

    public Date getDatePartage() {
        return datePartage;
    }

    public Matiere getMatiere() {
        return matiere;
    }

    public TypeRessource getType() {
        return typeR;
    }

    public Visibilite getVisibilite() {
        return visibilite;
    }

    public Groupe getGroupe() {
        return groupe;
    }

    public User getAuteur() {
        return auteur;
    }

    public ArrayList<Commentaire> getCommentaires() {
        return commentaires;
    }

    public int getNbCom() {
        return commentaires.size();
    }

    // Setters
    public void setTitre(String titre) {
        this.titre = titre;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public void setDatePartage(Date datePartage) {
        this.datePartage = datePartage;
    }

    public void setMatiere(Matiere matiere) {
        this.matiere = matiere;
    }

    public void setType(TypeRessource typeR) {
        this.typeR = typeR;
    }

    public void setVisibilite(Visibilite visibilite) {
        this.visibilite = visibilite;
    }

    public void setGroupe(Groupe groupe) {
        this.groupe = groupe;
    }

    public void setAuteur(User auteur) {
        this.auteur = auteur;
    }

    public void addCommentaire(Commentaire c) {
        commentaires.add(c);
    }

    @Override
    public String toString() {
        return "Titre: " + titre +
                " | Description: " + description +
                " | Date: " + datePartage.toString() +
                " | Matière: " + matiere.getNom() +
                " | Type: " + typeR +
                " | Auteur: " + auteur.getNomUtilisateur() +
                " | Commentaires: " + commentaires.size();
    }
}
