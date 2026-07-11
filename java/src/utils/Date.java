package utils;

public class Date {

    private static final int ANN_MAX = 2100;

    private int jour;
    private int moi;
    private int annee;

    public Date(int jour, int moi, int annee) {
        setJour(jour);
        setMoi(moi);
        setAnnee(annee);
    }

    // Getters
    public int getJour() {
        return jour;
    }

    public int getMoi() {
        return moi;
    }

    public int getAnnee() {
        return annee;
    }

    // Setters avec validation
    public void setJour(int jour) {
        if (jour < 1 || jour > 31) {
            System.out.println("Jour invalide.");
            return;
        }
        this.jour = jour;
    }

    public void setMoi(int moi) {
        if (moi < 1 || moi > 12) {
            System.out.println("Mois invalide.");
            return;
        }
        this.moi = moi;
    }

    public void setAnnee(int annee) {
        if (annee < 0 || annee > ANN_MAX) {
            System.out.println("Année invalide.");
            return;
        }
        this.annee = annee;
    }

    // Utilisé dans GroupeService::generateCode()
    public String timestamp() {
        return "" + annee + moi + jour;
    }

    @Override
    public String toString() {
        return jour + "/" + moi + "/" + annee;
    }
}
