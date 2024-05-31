<?php

require_once "../controller/controller_client.php";

$id_client = 2;
$commandes = commandeUser($id_client);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="/pages/css_files/historique.css">
    <title>Historique de commande</title>
</head>

<body>
    <div class="text-center border-bottom border-dark p-4">
        <h1>MES COMMANDES</h1>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-5">
            <?php foreach ($commandes as $commande) { ?>
                <div class="ligne">
                    <a href="/pages/panier_detail.php?id_panier=<?= $commande["id_panier"] ?>" class="lien">
                        <div class="row d-flex justify-content-between">
                            <div class="col-4">
                                <p class="m-0"><?= $commande["date_achat"] ?> - <?= $commande["id_panier"] ?></p>
                                <p class="text-secondary"><?= $commande["nbr_produit"] ?> Article(s)</p>
                            </div>
                            <div class="col-4">
                                <p class="m-0 h3">LIVRÉ</p>
                                <p><?= $commande["cout_total"] ?>€</p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>

        </div>
    </div>
</body>

</html>