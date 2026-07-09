<?php

use App\entity\Commentaire;
use App\Entity\Groupe;
use App\entity\Matiere;
use App\repository\MembreRepo;
use App\entity\Ressource;
use App\entity\TypeRessource;
use App\Entity\User;
use App\services\GroupeService;

$RESOURCE_TYPES = [
  "Cours",
  "TD",
  "TP",
  "Examen",
  "Rapport",
  "Mémoire",
  "Exercice",
  "Présentation",
  "Fiche de révision",
];

$TYPE_COLORS = [
  "Cours"            => ["bg" => "#1264a3", "text" => "#ffffff"],
  "TD"               => ["bg" => "#007a5a", "text" => "#ffffff"],
  "TP"               => ["bg" => "#1ba4c8", "text" => "#ffffff"],
  "Examen"           => ["bg" => "#4a154b", "text" => "#ffffff"],
  "Rapport"          => ["bg" => "#ecb22e", "text" => "#1d1c1d"],
  "Mémoire"          => ["bg" => "#611f69", "text" => "#ffffff"],
  "Exercice"         => ["bg" => "#e01e5a", "text" => "#ffffff"],
  "Présentation"     => ["bg" => "#2bac76", "text" => "#ffffff"],
  "Fiche de révision" => ["bg" => "#e8912d", "text" => "#ffffff"],
];

$GROUP_PALETTE = [
  "#1264a3",
  "#007a5a",
  "#611f69",
  "#e01e5a",
  "#4a154b",
  "#1ba4c8",
  "#2bac76",
  "#e8912d",
];

function groupColor($name)
{
  global $GROUP_PALETTE;
  $hash = 0;
  for ($i = 0; $i < strlen($name); $i++) {
    $hash = ord($name[$i]) + (($hash << 2) - $hash);
  }
  return $GROUP_PALETTE[abs($hash) % count($GROUP_PALETTE)];
}

function initials($name)
{
  $parts = explode(" ", $name);
  $init = "";
  foreach ($parts as $p) {
    $init .= $p[0] ?? "";
  }
  return strtoupper(substr($init, 0, 2));
}

function typeIconClass($type)
{
  switch ($type) {
    case "Cours":
      return "fa-book-open";
    case "Examen":
      return "fa-file-check";
    case "Présentation":
      return "fa-chalkboard";
    case "Mémoire":
    case "Rapport":
      return "fa-layer-group";
    default:
      return "fa-file-alt";
  }
}

function getMyGroupIds(): array
{
  if (!\App\config\Session::isConnected()) return [];
  $user = \App\config\Session::getCurrentUser();
  if (!$user) return [];
  $repo = new MembreRepo();
  $memberships = $repo->selectByUser($user->getId());
  return array_map(fn($m) => $m->getGroupeId(), $memberships);
}

$INITIAL_GROUPS = (new GroupeService())->getAllGroupes();

// ── Seed users ──────────────────────────────────────────────
$suAmadou = new User();
$suAmadou->setNom("Amadou Diallo");
$suAicha = new User();
$suAicha->setNom("Aïcha Sy");
$suMariama = new User();
$suMariama->setNom("Mariama Camara");
$suOumar = new User();
$suOumar->setNom("Oumar Traoré");
$suNadia = new User();
$suNadia->setNom("Nadia Bah");

$suFatou = new User();
$suFatou->setNom("Fatou B.");
$suMoussa = new User();
$suMoussa->setNom("Moussa K.");
$suCheikh = new User();
$suCheikh->setNom("Cheikh D.");
$suIbrahim = new User();
$suIbrahim->setNom("Ibrahim D.");
$suMariamaC = new User();
$suMariamaC->setNom("Mariama C.");
$suLea = new User();
$suLea->setNom("Léa M.");
$suPaul = new User();
$suPaul->setNom("Paul T.");
$suSofia = new User();
$suSofia->setNom("Sofia R.");
$suNadiaB = new User();
$suNadiaB->setNom("Nadia B.");
$suAdama = new User();
$suAdama->setNom("Adama C.");
$suBineta = new User();
$suBineta->setNom("Bineta F.");
$suKader = new User();
$suKader->setNom("Kader S.");

// ── Seed matières ───────────────────────────────────────────
$smInformatique = new Matiere();
$smInformatique->setNom("Informatique");
$smMathematiques = new Matiere();
$smMathematiques->setNom("Mathématiques");
$smEconomie = new Matiere();
$smEconomie->setNom("Économie");
$smDroit = new Matiere();
$smDroit->setNom("Droit");
$smPhysique = new Matiere();
$smPhysique->setNom("Physique");

// ── Seed groupes (fallback pour ressources) ─────────────────
$sgInformatique = new Groupe();
$sgInformatique->setId("1");
$sgInformatique->setNom("Informatique L3");
$sgSciencesPo = new Groupe();
$sgSciencesPo->setId("2");
$sgSciencesPo->setNom("Sciences Po Paris");
$sgMathsSup = new Groupe();
$sgMathsSup->setId("3");
$sgMathsSup->setNom("Maths Sup");
$sgDroitCivil = new Groupe();
$sgDroitCivil->setId("4");
$sgDroitCivil->setNom("Droit Civil");
$sgPhysiqueChimie = new Groupe();
$sgPhysiqueChimie->setId("5");
$sgPhysiqueChimie->setNom("Physique-Chimie");

// ── Seed resources ──────────────────────────────────────────
$r1 = new Ressource();
$r1->setTitre("Intro à l'intelligence artificielle");
$r1->setDescription("Cours complet couvrant les bases du machine learning, les réseaux de neurones et les algorithmes d'optimisation. Idéal pour les étudiants de L3 souhaitant une introduction solide avant le cours magistral.");
$r1->setType(TypeRessource::COURS);
$r1->setMatiere($smInformatique);
$r1->setAuteur($suAmadou);
$r1->setGroupe($sgInformatique);
$r1->setGroupeId(1);
$r1->setViews(312);
$r1->setDownloads(87);
$r1->setPinned(true);
$r1->setCreatedAt("il y a 2h");
$c1a = clone $suFatou;
$c1b = clone $suMoussa;
$c1c = clone $suCheikh;
$c1_1 = new Commentaire();
$c1_1->setMessage("Très utile, merci ! La partie sur les réseaux de neurones est particulièrement bien expliquée.");
$c1_1->setUser($c1a);
$c1_2 = new Commentaire();
$c1_2->setMessage("Est-ce que tu as le corrigé des exercices à la fin ?");
$c1_2->setUser($c1b);
$c1_3 = new Commentaire();
$c1_3->setMessage("Je recommande à tous ceux qui préparent le partiel de décembre.");
$c1_3->setUser($c1c);
$r1->setComments([$c1_1, $c1_2, $c1_3]);

$r2 = new Ressource();
$r2->setTitre("Cours d'Algèbre Linéaire — Espaces vectoriels");
$r2->setDescription("Support de cours sur les espaces vectoriels, la décomposition en valeurs singulières et les applications linéaires. Basé sur le programme de classe préparatoire MP.");
$r2->setType(TypeRessource::COURS);
$r2->setMatiere($smMathematiques);
$r2->setAuteur($suAicha);
$r2->setGroupe($sgMathsSup);
$r2->setGroupeId(3);
$r2->setViews(198);
$r2->setDownloads(54);
$r2->setPinned(false);
$r2->setCreatedAt("il y a 5h");
$c2a = clone $suIbrahim;
$c2b = clone $suMariamaC;
$c2_1 = new Commentaire();
$c2_1->setMessage("Super fichier ! Les démonstrations sont très claires.");
$c2_1->setUser($c2a);
$c2_2 = new Commentaire();
$c2_2->setMessage("La section sur les endomorphismes m'a vraiment aidé pour le colle.");
$c2_2->setUser($c2b);
$r2->setComments([$c2_1, $c2_2]);

$r3 = new Ressource();
$r3->setTitre("TD Macroéconomie S2 — Correction complète");
$r3->setDescription("Correction détaillée des TD de macroéconomie du semestre 2, incluant les modèles IS-LM, la courbe de Phillips et les politiques budgétaires keynésiennes.");
$r3->setType(TypeRessource::TD);
$r3->setMatiere($smEconomie);
$r3->setAuteur($suMariama);
$r3->setGroupe($sgSciencesPo);
$r3->setGroupeId(2);
$r3->setViews(445);
$r3->setDownloads(130);
$r3->setPinned(true);
$r3->setCreatedAt("hier");
$c3a = clone $suLea;
$c3b = clone $suPaul;
$c3c = clone $suSofia;
$c3_1 = new Commentaire();
$c3_1->setMessage("Merci, exactement ce qu'il me fallait pour la révision !");
$c3_1->setUser($c3a);
$c3_2 = new Commentaire();
$c3_2->setMessage("La question 3 sur la politique monétaire est un peu floue, tu peux développer ?");
$c3_2->setUser($c3b);
$c3_3 = new Commentaire();
$c3_3->setMessage("Excellent travail, les graphiques IS-LM sont très bien construits.");
$c3_3->setUser($c3c);
$r3->setComments([$c3_1, $c3_2, $c3_3]);

$r4 = new Ressource();
$r4->setTitre("Examen Droit des Contrats — Session 2024");
$r4->setDescription("Sujet de l'examen de droit des contrats de janvier 2024 avec les éléments de corrigé fournis par le chargé de TD. Cas pratique sur la nullité des contrats et la responsabilité contractuelle.");
$r4->setType(TypeRessource::EXAMEN);
$r4->setMatiere($smDroit);
$r4->setAuteur($suOumar);
$r4->setGroupe($sgDroitCivil);
$r4->setGroupeId(4);
$r4->setViews(289);
$r4->setDownloads(102);
$r4->setPinned(false);
$r4->setCreatedAt("il y a 2 jours");
$c4a = clone $suNadiaB;
$c4_1 = new Commentaire();
$c4_1->setMessage("Merci pour le partage ! Très utile pour préparer la session de rattrapage.");
$c4_1->setUser($c4a);
$r4->setComments([$c4_1]);

$r5 = new Ressource();
$r5->setTitre("Fiche de révision — Thermodynamique");
$r5->setDescription("Synthèse des notions clés de thermodynamique : premier et second principes, cycles de Carnot, enthalpie et entropie. Format condensé, idéal pour une relecture rapide avant l'examen.");
$r5->setType(TypeRessource::FICHE_REVISION);
$r5->setMatiere($smPhysique);
$r5->setAuteur($suNadia);
$r5->setGroupe($sgPhysiqueChimie);
$r5->setGroupeId(5);
$r5->setViews(167);
$r5->setDownloads(63);
$r5->setPinned(false);
$r5->setCreatedAt("il y a 3 jours");
$c5a = clone $suAdama;
$c5b = clone $suBineta;
$c5_1 = new Commentaire();
$c5_1->setMessage("Très bien structurée, les formules sont toutes là !");
$c5_1->setUser($c5a);
$c5_2 = new Commentaire();
$c5_2->setMessage("Super fiche, ça m'a économisé beaucoup de temps de relecture.");
$c5_2->setUser($c5b);
$r5->setComments([$c5_1, $c5_2]);

$r6 = new Ressource();
$r6->setTitre("Présentation — Systèmes distribués et cloud computing");
$r6->setDescription("Diaporama de 42 slides présenté en amphi sur les architectures distribuées, CAP theorem, et les services cloud AWS/GCP. Inclut les notes de présentation.");
$r6->setType(TypeRessource::PRESENTATION);
$r6->setMatiere($smInformatique);
$r6->setAuteur($suAmadou);
$r6->setGroupe($sgInformatique);
$r6->setGroupeId(1);
$r6->setViews(224);
$r6->setDownloads(71);
$r6->setPinned(false);
$r6->setCreatedAt("il y a 4 jours");
$c6a = clone $suFatou;
$c6b = clone $suKader;
$c6_1 = new Commentaire();
$c6_1->setMessage("Les slides sur le CAP theorem sont excellentes !");
$c6_1->setUser($c6a);
$c6_2 = new Commentaire();
$c6_2->setMessage("Tu pourrais partager les notes de présentation en PDF ?");
$c6_2->setUser($c6b);
$r6->setComments([$c6_1, $c6_2]);

$INITIAL_RESOURCES = [$r1, $r2, $r3, $r4, $r5, $r6];
