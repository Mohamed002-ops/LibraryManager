# 📚 Application Web de Gestion d'une Bibliothèque

## 📝 Objectif

Ce projet a pour but de développer une application web simple permettant la gestion d'une bibliothèque :

- Gérer les **livres** (ajout, modification, suppression, consultation)
- Gérer les **usagers** (lecteurs)
- Gérer les **emprunts** (qui a emprunté quoi, quand et pour combien de temps)

---

## 🚀 Fonctionnalités

### Livres
- ➕ Ajouter un livre
- 📋 Lister les livres disponibles
- ✏️ Modifier un livre
- ❌ Supprimer un livre

### Usagers
- ➕ Ajouter un usager
- 📋 Lister les usagers

### Emprunts
- 📌 Enregistrer un emprunt
- ✅ Marquer un livre comme retourné
- 📄 Voir la liste des emprunts (en cours ou passés)

---


## ⚙️ Technologies utilisées

- PHP (procédural)
- MySQL avec PDO
- HTML / CSS
- (Optionnel) JavaScript pour améliorer l’expérience utilisateur

---

## 📐 Bonnes pratiques respectées

- Séparation du code HTML / PHP (`header.php`, `footer.php`)
- Sécurité des formulaires via `htmlspecialchars()` (contre les attaques XSS)
- Utilisation de **PDO** pour toutes les connexions à la base de données
- Système de navigation simple et clair
- (Optionnel) Pagination des listes longues

---

# 📚 Modèle de Base de Données – Application de Gestion de Bibliothèque

## 📊 Schéma Relationnel

### 🔹 Table `livres`
| Champ           | Type             | Contraintes                  |
|----------------|------------------|------------------------------|
| id_livre       | INT              | PRIMARY KEY, AUTO_INCREMENT |
| titre          | VARCHAR(255)     | NOT NULL                     |
| auteur         | VARCHAR(255)     | NOT NULL                     |
| editeur        | VARCHAR(255)     |                              |
| annee          | YEAR             |                              |
| isbn           | VARCHAR(20)      | UNIQUE                       |
| quantite_total | INT              | NOT NULL                     |

---

### 🔹 Table `usagers`
| Champ           | Type             | Contraintes                  |
|----------------|------------------|------------------------------|
| id_usager      | INT              | PRIMARY KEY, AUTO_INCREMENT |
| nom            | VARCHAR(100)     | NOT NULL                     |
| prenom         | VARCHAR(100)     | NOT NULL                     |
| email          | VARCHAR(150)     | UNIQUE, NOT NULL             |
| numero_carte   | VARCHAR(50)      | UNIQUE, NOT NULL             |

---

### 🔹 Table `emprunts`
| Champ           | Type             | Contraintes                              |
|----------------|------------------|------------------------------------------|
| id_emprunt     | INT              | PRIMARY KEY, AUTO_INCREMENT             |
| id_usager      | INT              | FOREIGN KEY → `usagers(id_usager)`      |
| id_livre       | INT              | FOREIGN KEY → `livres(id_livre)`        |
| date_emprunt   | DATE             | NOT NULL                                 |
| date_retour    | DATE             | NULL (devient NOT NULL lors du retour)  |
| duree_jours    | INT              | NOT NULL                                |

---

### 🔹 (Optionnel) Table `retards`
| Champ           | Type             | Contraintes                               |
|----------------|------------------|-------------------------------------------|
| id_retard      | INT              | PRIMARY KEY, AUTO_INCREMENT               |
| id_emprunt     | INT              | FOREIGN KEY → `emprunts(id_emprunt)`     |
| jours_retard   | INT              | NOT NULL                                  |

---

## 🔗 Relations
- Un **usager** peut faire plusieurs **emprunts**
- Un **livre** peut être emprunté plusieurs fois
- Un **emprunt** lie un seul **livre** à un seul **usager**



---

## 📁 Structure du projet

/bibliotheque/
│
├── includes/
│ ├── db.php
│ ├── header.php
│ └── footer.php
│
├── livres/
│ ├── ajouter.php
│ ├── modifier.php
│ ├── supprimer.php
│ └── lister.php
│
├── usagers/
│ ├── ajouter.php
│ └── lister.php
│
├── emprunts/
│ ├── emprunter.php
│ ├── retour.php
│ └── liste.php
│
├── index.php
└── style.css


---

## 🧪 Installation et utilisation

1. Cloner le projet ou le télécharger.
2. Créer une base de données MySQL nommée `bibliotheque`.
3. Importer le script SQL de création des tables (voir `bdd.sql` si fourni).
4. Configurer la connexion PDO dans `includes/db.php`.
5. Lancer le projet dans un serveur local (XAMPP, WAMP ou autre).

---

## 🎨 Touche personnelle

- Thème visuel personnalisé avec CSS
- Affichage des emprunts en couleur selon le statut (en retard, retourné, en cours)
- Statistiques : nombre total de livres, usagers et emprunts


---

## 👤 Auteur

- Nom : **Mohamed Ndiaye**
- Projet scolaire - Gestion d’une bibliothèque