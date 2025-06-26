<?php

session_start();
if(isset($_SESSION['user'])){
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="../resources/css/style.css">
</head>

<body>


    <?php include "../includes/header.php"; ?>
    <div class="section">

        <div class="container">
            <div class="header">
                <h2 class="title">A Propos de nous</h2>
                <p class="subtitle">
                    Simplifiez la gestion de votre bibliothèque grâce à
                    notre plateforme moderne et intuitive.
                    Library Manager vous permet de suivre les emprunts,
                    gérer les collections, consulter les disponibilités et
                    bien plus encore, le tout depuis une seule interface.
                </p>

                <p>
                    Notre plateforme est dédiée à la diffusion du savoir et à la simplification de l’accès à
                    l’information. Depuis notre lancement, nous mettons tout en œuvre pour proposer des services utiles,
                    intuitifs et performants.
                </p>
                <p>
                    Grâce à une équipe passionnée et des outils modernes, nous accompagnons nos utilisateurs dans leurs
                    projets, leurs recherches, et leur apprentissage.
                </p>
                <p>
                    Notre vision : un monde où la connaissance est librement accessible à tous.
                </p>
                <p>
                    N’hésitez pas à nous contacter si vous avez des questions ou des suggestions.   
                    Nous sommes là pour vous aider à atteindre vos objectifs.
                </p>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="./resources/js/menu.js"></script>
</body>

</html>