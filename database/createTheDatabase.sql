CREATE DATABASE bibliotheque;
USE bibliotheque;

CREATE TABLE livres (
    id_livre INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(255) NOT NULL,
    editeur VARCHAR(255),
    annee YEAR,
    isbn VARCHAR(20) UNIQUE,
    quantite_total INT NOT NULL
);

CREATE TABLE usagers (
    id_usager INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    numero_carte VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE emprunts (
    id_emprunt INT AUTO_INCREMENT PRIMARY KEY,
    id_usager INT NOT NULL,
    id_livre INT NOT NULL,
    date_emprunt DATE NOT NULL,
    date_retour DATE,
    duree_jours INT NOT NULL,
    statut ENUM('en_cours', 'retourne', 'en_retard') DEFAULT 'en_cours',
    FOREIGN KEY (id_usager) REFERENCES usagers(id_usager) ON DELETE CASCADE,
    FOREIGN KEY (id_livre) REFERENCES livres(id_livre) ON DELETE CASCADE,
    CHECK (date_retour IS NULL OR date_retour >= date_emprunt)
);

CREATE TABLE retards (
    id_retard INT AUTO_INCREMENT PRIMARY KEY,
    id_emprunt INT NOT NULL,
    jours_retard INT NOT NULL,
    FOREIGN KEY (id_emprunt) REFERENCES emprunts(id_emprunt) ON DELETE CASCADE
);


CREATE TABLE categories (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie VARCHAR(100) NOT NULL UNIQUE
);

ALTER TABLE livres ADD id_categorie INT;
ALTER TABLE livres ADD FOREIGN KEY (id_categorie) REFERENCES categories(id_categorie);


ALTER TABLE categories ADD image VARCHAR(255);


UPDATE categories SET image = 'https://images.unsplash.com/photo-1553729459-efe14ef6055d' WHERE nom_categorie = 'Science-Fiction';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f' WHERE nom_categorie = 'Littérature classique';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1509021436665-8f07dbf5bf1d' WHERE nom_categorie = 'Philosophie';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1496104679561-38b9ef542a42' WHERE nom_categorie = 'Romans contemporains';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1604021743015-04ba763fda3d' WHERE nom_categorie = 'Jeunesse';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1604079627613-9b94d3c92a0d' WHERE nom_categorie = 'Fantastique';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1596495577886-d920f1fb7238' WHERE nom_categorie = 'Histoire';
UPDATE categories SET image = 'https://images.unsplash.com/photo-1603791440384-56cd371ee9a7' WHERE nom_categorie = 'Biographie';
