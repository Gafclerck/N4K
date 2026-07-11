package entity;

import utils.Date;

public class Commentaire {

    private String message;
    private Date date;
    private Ressource ressource;
    private User user;

    public Commentaire(String message, Date date, Ressource ressource, User user) {
        this.message = message;
        this.date = date;
        this.ressource = ressource;
        this.user = user;
    }

    // Getters
    public String getMessage() { return message; }
    public Date getDate() { return date; }
    public Ressource getRessource() { return ressource; }
    public User getUser() { return user; }

    // Setters
    public void setMessage(String message) { this.message = message; }
    public void setDate(Date date) { this.date = date; }
    public void setRessource(Ressource ressource) { this.ressource = ressource; }
    public void setUser(User user) { this.user = user; }

    @Override
    public String toString() {
        return "[" + date.toString() + "] " + user.getNomUtilisateur() + " : " + message;
    }
}
