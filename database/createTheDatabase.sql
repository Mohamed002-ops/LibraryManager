-- Creer la base de donnee
CREATE DATABASE bib;

-- Utiliser la base de donnee
USE bib;

-- Creer la table categories
CREATE TABLE categories (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie VARCHAR(100) NOT NULL UNIQUE,
    image VARCHAR(255)
);


-- Creer la table Livres
CREATE TABLE livres (
    id_livre INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    auteur VARCHAR(255) NOT NULL,
    editeur VARCHAR(255),
    annee YEAR,
    isbn VARCHAR(20) UNIQUE,
    quantite_total INT NOT NULL,
    id_categorie INT,
    FOREIGN KEY (id_categorie) REFERENCES categories(id_categorie)
);

-- Creer la table Usagers
CREATE TABLE usagers (
    id_usager INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telephone VARCHAR(15) UNIQUE
);

-- Creer la table Emprunts
CREATE TABLE emprunts (
    id_emprunt INT AUTO_INCREMENT PRIMARY KEY,
    id_usager INT NOT NULL,
    id_livre INT NOT NULL,
    date_emprunt DATE NOT NULL,
    date_retour DATE,
    statut ENUM('en_cours', 'retourne', 'en_retard') DEFAULT 'en_cours',
    FOREIGN KEY (id_usager) REFERENCES usagers(id_usager) ON DELETE CASCADE,
    FOREIGN KEY (id_livre) REFERENCES livres(id_livre) ON DELETE CASCADE,
    CHECK (date_retour IS NULL OR date_retour >= date_emprunt)
);

-- Inserer des donnee dans la table Categories
INSERT INTO categories (nom_categorie) VALUES
('Science-Fiction'),
('Littérature classique'),
('Philosophie'),
('Romans contemporains'),
('Jeunesse'),
('Fantastique'),
('Histoire'),
('Biographie');


-- Inserer des donnee dans la table Livres
INSERT INTO livres (titre, auteur, editeur, annee, isbn, quantite_total, id_categorie) VALUES
('Dune', 'Frank Herbert', 'Chilton Books', 1965, '9780441013593', 5, 1),
('Fondation', 'Isaac Asimov', 'Gnome Press', 1951, '9782070360536', 4, 1),
('Neuromancien', 'William Gibson', 'Ace Books', 1984, '9780441569595', 3, 1),
('Les Misérables', 'Victor Hugo', 'A. Lacroix', 1862, '9782070409181', 5, 2),
('Madame Bovary', 'Gustave Flaubert', 'Revue de Paris', 1857, '9782070413119', 3, 2),
('Germinal', 'Émile Zola', 'Charpentier', 1885, '9782070360246', 4, 2),
('Le Banquet', 'Platon', 'GF Flammarion', -380, '9782080702373', 2, 3),
('Critique de la raison pure', 'Immanuel Kant', 'Felix Meiner', 1781, '9782711612679', 2, 3),
('Ainsi parlait Zarathoustra', 'Friedrich Nietzsche', 'Gallimard', 1883, '9782070324200', 3, 3),
('L’Élégance du hérisson', 'Muriel Barbery', 'Gallimard', 2006, '9782070780938', 4, 4),
('La Vie est facile, ne t’inquiète pas', 'Agnès Martin-Lugand', 'Michel Lafon', 2015, '9782749932807', 3, 4),
('Chanson douce', 'Leïla Slimani', 'Gallimard', 2016, '9782070196678', 3, 4),
('Harry Potter à l’école des sorciers', 'J.K. Rowling', 'Gallimard', 1997, '9782070643028', 6, 5),
('Le Petit Nicolas', 'René Goscinny', 'IMAV', 1959, '9782203001023', 4, 5),
('Matilda', 'Roald Dahl', 'Puffin Books', 1988, '9780142410370', 4, 5),
('Le Seigneur des Anneaux', 'J.R.R. Tolkien', 'Allen & Unwin', 1954, '9780261102385', 5, 6),
('Eragon', 'Christopher Paolini', 'Knopf', 2002, '9780375826689', 3, 6),
('Les Chroniques de Narnia', 'C.S. Lewis', 'HarperCollins', 1950, '9780064471190', 4, 6),
('Sapiens', 'Yuval Noah Harari', 'Harvill Secker', 2011, '9780099590088', 4, 7),
('L’Ordre du temps', 'Carlo Rovelli', 'Flammarion', 2018, '9782081421105', 3, 7),
('Une brève histoire du temps', 'Stephen Hawking', 'Bantam', 1988, '9780553176988', 4, 7),
('Long Walk to Freedom', 'Nelson Mandela', 'Little, Brown', 1994, '9780316548182', 3, 8),
('Steve Jobs', 'Walter Isaacson', 'Simon & Schuster', 2011, '9781451648539', 3, 8),
('Marie Curie: A Biography', 'Marilyn Bailey Ogilvie', 'Greenwood Press', 2004, '9780313057441', 2, 8),
('Le Nom de la rose', 'Umberto Eco', 'Grasset', 1980, '9782226032336', 3, 2),
('L’Insoutenable légèreté de l’être', 'Milan Kundera', 'Gallimard', 1984, '9782070379242', 3, 4),
('Bel-Ami', 'Guy de Maupassant', 'Charpentier', 1885, '9782070408409', 3, 2),
('Voyage au centre de la Terre', 'Jules Verne', 'Hetzel', 1864, '9782070622560', 4, 6),
('Le Meilleur des mondes', 'Aldous Huxley', 'Chatto & Windus', 1932, '9782070368222', 4, 1);


-- Ajout des images des categories dans la table Categories
UPDATE categories SET image = '/Library/resources/images/livre-science-fiction.jpeg' WHERE nom_categorie = 'Science-Fiction';
UPDATE categories SET image = '/Library/resources/images/livres.jpeg' WHERE nom_categorie = 'Littérature classique';
UPDATE categories SET image = '/Library/resources/images/livre-philo.jpeg' WHERE nom_categorie = 'Philosophie';
UPDATE categories SET image = '/Library/resources/images/livre-science-fiction.jpeg' WHERE nom_categorie = 'Romans contemporains';
UPDATE categories SET image = '/Library/resources/images/livre-jeunesse.jpeg' WHERE nom_categorie = 'Jeunesse';
UPDATE categories SET image = '/Library/resources/images/livre-fantastique.jpeg' WHERE nom_categorie = 'Fantastique';
UPDATE categories SET image = '/Library/resources/images/livre-histoire.jpeg' WHERE nom_categorie = 'Histoire';
UPDATE categories SET image = '/Library/resources/images/livre-science-fiction.jpeg' WHERE nom_categorie = 'Biographie';
