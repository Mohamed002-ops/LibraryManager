-- Vérification de l’état des emprunts en cours :

SELECT e.id_emprunt, u.nom, u.prenom, l.titre, e.date_emprunt
FROM emprunts e
JOIN usagers u ON e.id_usager = u.id_usager
JOIN livres l ON e.id_livre = l.id_livre
WHERE e.date_retour IS NULL;


-- Voir les retards actuels (avec calcul si date_retour NULL) :
SELECT e.id_emprunt, u.nom, l.titre,
       DATEDIFF(CURDATE(), e.date_emprunt) - e.duree_jours AS jours_de_retard
FROM emprunts e
JOIN usagers u ON e.id_usager = u.id_usager
JOIN livres l ON e.id_livre = l.id_livre
WHERE e.date_retour IS NULL
  AND DATEDIFF(CURDATE(), e.date_emprunt) > e.duree_jours;


-- Mettre à jour la table retards automatiquement (optionnel via script ou trigger) :
INSERT INTO retards (id_emprunt, jours_retard)
SELECT e.id_emprunt,
       DATEDIFF(CURDATE(), e.date_emprunt) - e.duree_jours
FROM emprunts e
LEFT JOIN retards r ON r.id_emprunt = e.id_emprunt
WHERE e.date_retour IS NULL
  AND DATEDIFF(CURDATE(), e.date_emprunt) > e.duree_jours
  AND r.id_emprunt IS NULL;



-- Considérer l’ajout automatique du champ statut (si ajouté précédemment) :
UPDATE emprunts
SET statut = 'retourne'
WHERE date_retour IS NOT NULL;

UPDATE emprunts
SET statut = 'en_retard'
WHERE date_retour IS NULL AND DATEDIFF(CURDATE(), date_emprunt) > duree_jours;

UPDATE emprunts
SET statut = 'en_cours'
WHERE date_retour IS NULL AND DATEDIFF(CURDATE(), date_emprunt) <= duree_jours;
