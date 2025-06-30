<?php

session_start();


try {
    $pdo = new PDO('mysql:host=localhost;dbname=bib;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_livre'])) {
        $id_livre = (int) $_POST['id_livre'];
        // Vérifier si l'utilisateur a bien emprunté ce livre et que le statut est "en_cours"
        $stmt = $pdo->prepare("SELECT * FROM emprunts WHERE id_livre = :id AND statut = 'en_cours' OR statut = 'en_retard'");
        $stmt->execute([
            ':id' => $id_livre
        ]);


        $emprunt = $stmt->fetch();
        echo $id_usager;
        echo $id_livre;


        if (!$emprunt) {
            $_SESSION['errors'][] = "Aucun emprunt en cours trouvé pour ce livre.";
            echo "Aucun emprunt en cours trouvé pour ce livre.";
        } else {
            // Mettre à jour le statut de l'emprunt
            $updateEmprunt = $pdo->prepare("UPDATE emprunts SET statut = 'retourne' WHERE id_livre = :id");
            $updateEmprunt->execute([
                ':id' => $id_livre
            ]);


            // Augmenter la quantité disponible
            $updateStock = $pdo->prepare("UPDATE livres SET quantite_total = quantite_total + 1 WHERE id_livre = :id");
            $updateStock->execute([':id' => $id_livre]);
            $_SESSION['success'] = "Livre rendu avec succès.";
            echo "livre";
        }


        header("Location: ../views/gestion.php?form=list-borrow");
        exit;
    }


} catch (PDOException $e) {
    $_SESSION['errors'][] = "Erreur : " . $e->getMessage();
    exit;
}

?>