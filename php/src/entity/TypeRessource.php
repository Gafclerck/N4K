<?php

namespace App\Entity;

enum TypeRessource: string
{
    case TP = "TP";
    case TD = "TD";
    case EXO = "EXO";
    case COURS = "Cours";
    case EXAMEN = "Examen";
    case RAPPORT = "Rapport";
    case MEMOIRE = "Mémoire";
    case EXERCICE = "Exercice";
    case PRESENTATION = "Présentation";
    case FICHE_REVISION = "Fiche de révision";
}
