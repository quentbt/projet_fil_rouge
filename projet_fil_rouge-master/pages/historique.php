<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . "/controller/controller_client.php");

$id_client = 1;
$commandes = commandeUser($id_client);

?>
<!DOCTYPE html>
<html lang="en">

<?php
require_once '../menu/menu.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <link rel="stylesheet" href="/pages/css_files/historique.css">
    <title>Historique de commande</title>
    <style>
        
        body {
            background: radial-gradient(ellipse farthest-corner at bottom right, #e0ffff,beige );
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .form-card {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .ligne {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .ligne:hover {
            transform: scale(1.05);
        }

        .lien {
            text-decoration: none;
            color: inherit;
        }

        .lien:hover {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>

<body>
    <div class="container form-card text-center">
        <div class="text-center border-bottom border-dark p-4">
            <h1>MES COMMANDES</h1>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-8">
                <?php foreach ($commandes as $commande) { ?>
                    <div class="ligne">
                        <a href="/pages/panier_detail.php?id_panier=<?= $commande["id_panier"] ?>" class="lien">
                            <div class="row d-flex justify-content-between">
                                <div class="col-6">
                                    <p class="m-0"><?= $commande["date_achat"] ?> - <?= $commande["id_panier"] ?></p>
                                    <p class="text-secondary"><?= $commande["nbr_produit"] ?> Article(s)</p>
                                </div>
                                <div class="col-4 text-end">
                                    <p class="m-0 h3">LIVRÉ</p>
                                    <p><?= $commande["cout_total"] ?>€</p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
