# CoachPro — Plateforme de Réservation de Séances Sportives

CoachPro est une application web développée en **PHP orienté objet (MVC)** permettant de mettre en relation des **coachs sportifs** et des **sportifs** via un système de **séances**, **réservations** et **dashboards personnalisés**.

Le projet utilise **Twig** comme moteur de templates et une base de données **PostgreSQL**.

---

## Objectifs du projet

- Appliquer l’architecture **MVC en PHP**
- Gérer l’authentification et les rôles (Coach / Sportif)
- Mettre en place un système de réservation sécurisé
- Manipuler une base de données relationnelle
- Créer une interface moderne et responsive

---

## Fonctionnalités

### Authentification
- Inscription
- Connexion
- Déconnexion
- Gestion des rôles (`coach`, `sportif`)
- Protection des routes selon le rôle

---

### Coach
- Dashboard avec statistiques
- Gestion du profil (modifier informations)
- Création de séances
- Modification de séances
- Suppression de séances (bloquée si réservée)
- Visualisation des réservations

---

### Sportif
- Consultation des coachs
- Consultation des séances disponibles
- Réservation d’une séance
- Historique des réservations
- Gestion du profil

---

### Statistiques Coach
- Nombre total de séances
- Nombre de séances disponibles
- Nombre de séances réservées

---

## Technologies utilisées

- **PHP 8+**
- **Architecture MVC**
- **Twig** (Templates)
- **PostgreSQL**
- **HTML / Tailwind CSS**
- **JavaScript (léger)**
- **Sessions PHP**
- **Routing personnalisé**

---

## Structure du projet

```
CoachPro(MVC)/
│
├── app/
│ ├── Controllers/
│ ├── Models/
│ ├── Views/
│
├── core/
│ ├── Router.php
│ ├── Controller.php
│ ├── Security.php
│ ├── Session.php
│
├── public/
│ ├── index.php
│
├── vendor/
│
├── database/
│ └── schema.sql
│
└── README.md
```

---

## Base de données

### Tables principales :
- `utilisateur`
- `coach`
- `sportif`
- `seance`
- `reservation`

### Contraintes importantes :
- Une séance ne peut être réservée qu’une seule fois
- Une séance réservée ne peut pas être supprimée
- Un utilisateur possède un seul rôle

---

## Routes principales

### Coach
```
/coach/profile
/coach/seances
/coach/seances/create
/coach/seances/edit/{id}
/coach/seances/update
/coach/reservations
```

### Sportif
```
/sportif/profile
/sportif/coaches
/sportif/seances
/sportif/reservations/create
/sportif/history
```

---

## 🔒 Sécurité

- Vérification des rôles via `Security::requireRole()`
- Protection des actions sensibles
- Validation des données
- Vérification de propriété (coach ↔ séance)

---

## 💬 Flash Messages

- Succès
- Erreurs
- Messages temporaires
- Suppression automatique après affichage

---

## Installation

### Installer les dépendances
```bash
https://github.com/rachadelrhilani/CoachPro-MVC
