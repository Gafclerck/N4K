package entity;

import utils.Date;

public class Membre {
    private Date dateIntegration;
    private Groupe groupe;
    private User user;
    private TypeMembre role;

    public Membre(Date dateIntegration, Groupe groupe, User user) {
        this.dateIntegration = dateIntegration;
        this.groupe = groupe;
        this.user = user;
        this.role = TypeMembre.MEMBRE;
    }

    // Getters
    public  Date getDateIntegration() { return dateIntegration; }
    public Groupe getGroupe() 
    { 
        return groupe; 
    }
    public User getUser() { return user; }
    public TypeMembre getRole() { return role; }

    // Setters
    public void setDateIntegration(Date dateIntegration) { this.dateIntegration = dateIntegration; }
    public void  setGroupe(Groupe groupe) { this.groupe = groupe; }
    public void setUser(User user) { this.user = user; }
    public void setTypeMembre(TypeMembre role) { this.role = role; }
}
