<?php
require_once __DIR__ . '/../config/db.php';

class Livre {
    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM livres");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM livres WHERE id_livre = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function add($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO livres (titre, auteur, editeur, annee, isbn, quantite_total) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['titre'], $data['auteur'], $data['editeur'], $data['annee'],
            $data['isbn'], $data['quantite_total']
        ]);
    }

    public static function update($id, $data) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE livres SET titre = ?, auteur = ?, editeur = ?, annee = ?, isbn = ?, quantite_total = ? WHERE id_livre = ?");
        return $stmt->execute([
            $data['titre'], $data['auteur'], $data['editeur'], $data['annee'],
            $data['isbn'], $data['quantite_total'], $id
        ]);
    }

    public static function delete($id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM livres WHERE id_livre = ?");
        return $stmt->execute([$id]);
    }
}
