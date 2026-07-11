# N4K – Plateforme de partage de ressources académiques

## Présentation

N4K est une plateforme web permettant aux étudiants de partager, rechercher, consulter et télécharger des ressources académiques tout en collaborant au sein de groupes de travail.

Le projet a été réalisé dans le cadre du projet de deuxième semestre du cours d'Analyse. Son objectif était de couvrir l'ensemble du cycle de développement d'une application, depuis l'analyse des besoins jusqu'à son implémentation.

---

# Objectifs du projet

L'application permet aux étudiants de :

- partager des ressources académiques ;
- rechercher des ressources ;
- télécharger des ressources ;
- commenter les ressources ;
- organiser les ressources en groupes de travail ;
- partager une ressource en mode public ou privé.

L'objectif pédagogique était également de mettre en pratique les différentes étapes du génie logiciel :

- analyse des besoins ;
- modélisation UML ;
- prototypage UI/UX ;
- conception orientée objet ;
- implémentation dans plusieurs langages.

---

# Les différentes réalisations du projet

## 1. Analyse

Une étude complète du projet a été réalisée avant toute phase de développement.

Elle comprend notamment :

- Diagramme de cas d'utilisation (Use Case)
- Diagramme de classes
- Diagrammes de séquence
- Diagrammes d'activités
- Modèle Entité-Relation (MER)

Cette étape a permis de définir clairement les fonctionnalités, les interactions entre les utilisateurs ainsi que les règles métier.

---

## 2. Prototype UI/UX

Avant le développement, une maquette complète de l'application a été conçue sur Figma afin de valider l'expérience utilisateur et l'organisation des différentes interfaces.

Le prototype est disponible ici :

https://www.figma.com/design/S1Jw4pjpspAywyjumIxIOd/N4K?m=auto&t=AyLaV1IlzoSd4CKx-1

Le prototype couvre notamment :

- les pages d'authentification ;
- la page d'accueil ;
- la gestion des ressources ;
- les groupes ;
- les profils utilisateurs ;
- les différentes interactions utilisateur.

---

## 3. Implémentation en algorithmes orientés objet

Une première implémentation a été réalisée en algorithmes POO afin de traduire la conception UML en logique métier.

Cette étape a permis de valider :

- les classes ;
- les relations entre objets ;
- les responsabilités des différentes entités ;
- les traitements métier.

---

## 4. Implémentation Java (Console)

Le projet a ensuite été développé en Java sous forme d'application console, sans persistance de données.

Cette version avait pour objectif de mettre en pratique :

- la programmation orientée objet ;
- l'encapsulation ;
- l'héritage ;
- la manipulation des collections Java.

---

## 5. Développement de l'application Web en PHP

La dernière étape consiste au développement complet de la plateforme avec persistance des données.

### Technologies utilisées

- PHP
- MySQL
- PDO
- HTML
- Tailwind CSS
- Javascript (Peu utilise pas pour la logique juste pour certains types de view un peucomplexe )

---

# Architecture du projet

L'application suit une architecture MVC organisée en plusieurs couches.

## Couche Entité

Les entités représentent les objets métier définis à partir du diagramme de classes UML.

Exemples :

- User
- Ressource
- Groupe
- Commentaire

---

## Couche Repository

La couche Repository est responsable de toutes les opérations de persistance.

Caractéristiques :

- une classe `AbstractRepo` centralise les opérations communes ;
- chaque entité possède son propre Repository ;
- utilisation du pattern **Singleton** ;
- utilisation de **PDO** pour les accès à la base de données.

Exemples :

- UserRepo
- RessourceRepo
- GroupeRepo
- CommentaireRepo

---

## Couche Service

La logique métier est entièrement isolée dans les services.

Chaque service :

- applique les règles métier ;
- valide les données ;
- communique avec les repositories.

Les repositories sont injectés via le constructeur afin de respecter une séparation claire des responsabilités.

Les services utilisent également le pattern **Singleton**.

---

## Couche Controller

Les contrôleurs assurent la communication entre les vues et les services.

Ils sont responsables de :

- recevoir les requêtes utilisateur ;
- appeler les services appropriés ;
- transmettre les données aux vues.

---

## Couche View

Les vues sont responsables uniquement de l'affichage.

L'interface a été développée avec une attention particulière portée à :

- la simplicité ;
- la lisibilité ;
- l'expérience utilisateur.

---

# Base de données

Le projet utilise MySQL avec PDO.

La persistance est entièrement gérée par les repositories.

Les principales entités sont :

- Utilisateur
- Ressource
- Groupe
- Commentaire

---

# Principes de conception utilisés

Le développement repose sur plusieurs principes de conception :

- Programmation Orientée Objet
- Architecture MVC
- Séparation des responsabilités
- Encapsulation
- Héritage
- Injection de dépendances
- Pattern Singleton
- Repository Pattern

---

# Ce que j'ai pu realiser

- Authentification des utilisateurs
- Publication de ressources
- Définition de la visibilité (publique ou privée)
- Téléchargement des ressources
- Recherche de ressources
- Consultation des ressources
- Création de groupes
- Partage des ressources dans un groupe
- Publication de commentaires

---

# Utilisation de l'intelligence artificielle

L'intelligence artificielle a été utilisée comme outil d'assistance pour la conception de l'interface utilisateur et la documentation technique.

Elle a principalement été exploitée pour :

## Optimisation de l'interface utilisateur

- amélioration de l'expérience utilisateur (UI/UX) ;
- propositions d'organisation des interfaces ;
- amélioration du design visuel.

Toutes les décisions fonctionnelles, la logique métier et l'architecture ont été conçues et implémentées par l'auteur.

## Gestion sécurisée des fichiers

L'IA a également été utilisée comme support documentaire pour approfondir :

- la gestion des uploads de fichiers ;
- la validation des types MIME ;
- les extensions autorisées ;
- les contrôles de sécurité lors de l'envoi des fichiers.

# Ce que j'ai pas pu faire dans ces delai et pervoi de faire ( je le mettrai dans la brache afterExam )

Plusieurs fonctionnalités sont prévues pour les prochaines versions :

## Back-office administrateur

- gestion des utilisateurs ;
- gestion des ressources ;
- modération des commentaires ;
- administration des groupes.

## Gestion avancée des groupes

- ajout de membres ;
- suppression de membres ;
- gestion des rôles ;
- suppression d'un groupe ;
- administration complète des groupes par leur créateur.

---
