<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . "/controller/controller_panier.php");
require_once($root . "/controller/controller_client.php");

$id_panier = $_GET["id_panier"];
// $id_client = $_SESSION["id_client"];
$id_client = 1;
$panier = produitCommande($id_panier);
$prixTotal = prixQtt($id_panier);

$tva = 0;
$adresseLivraison = adresseLivraison($id_client);
$adresseFacture = adresseFacturation($id_client);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css_files/panier.css">
    <title>Detail panier</title>
</head>

<body>
    <h1 class="text-center mb-4">Commande n°<?= $id_panier ?></h1>
    <div class="row center d-flex justify-content-between">
        <div class="col-5">
            <?php foreach ($panier as $pan) { ?>
                <div class="produit_panier m-4">
                    <div class="col-3">
                        <img src="<?= $pan["image_produit"] ?>" alt="">
                    </div>
                    <div class="col-7 ml-4">
                        <?= $pan["nom"] ?>
                        <br>
                        <?= $pan["description"] ?>
                    </div>
                    <div class="col-2 text-center d-flex flex-column align-items-end">
                        <p><?= $pan["prix"] ?>€</p>
                        <input type="hidden" name="id_produit[]" id="id_produit" value="<?= $pan["id_produit"] ?>">
                        <select name="quantite[]" disabled>
                            <option value="<?= $pan["quantite"] ?>"><?= $pan["quantite"] ?></option>
                        </select>
                        <br>
                        <button class="bouton_suppr_produit_panier" type="button" disabled>
                            <span class="material-symbols-outlined">
                                delete
                            </span>
                        </button>
                    </div>
                </div>
            <?php
                $tva += ($pan["prix"] * $pan["quantite"]) * (20 / 100);
            } ?>
        </div>
        <div class="col-5">
            <div class="border-bottom border-dark">
                <div class="row m-2 h5">
                    <div class="col-10">TOTAL :</div>
                    <div class="col-2 text-end"><?= $prixTotal ?>€</div>
                </div>
                <div class="row tva m-2 h6 mb-4">
                    <div class="col-10">TVA :</div>
                    <div class="col-2 text-end"><?= $tva ?>€</div>
                </div>
            </div>
            <div class="border-bottom border-dark">
                <?php foreach ($adresseLivraison as $adresse) { ?>
                    <h3 class="mt-4">Adresse de livraison</h3>
                    <p class="m-1"><?= $adresse["nom"] ?> <?= $adresse["prenom"] ?></p>
                    <p class="m-1"><?= $adresse["adresse1"] ?></p>
                    <p class="m-1"><?= $adresse["code_postal"] ?> <?= $adresse["ville"] ?></p>
                    <p class="m-1"><?= strtoupper($adresse["pays"]) ?></p>
                    <p class="m-1 mb-4"><?= chunk_split($adresse["telephone"], 2, " ") ?></p>
                <?php } ?>
            </div>
            <div class="border-bottom border-dark">
                <?php foreach ($adresseFacture as $adresse) { ?>
                    <h3 class="mt-4">Adresse de facturation</h3>
                    <p class="m-1"><?= $adresse["nom_fact"] ?> <?= $adresse["prenom_fact"] ?></p>
                    <p class="m-1"><?= $adresse["adresse_fact"] ?></p>
                    <p class="m-1"><?= $adresse["code_post_fact"] ?> <?= $adresse["ville_fact"] ?></p>
                    <p class="m-1"><?= strtoupper($adresse["pays_fact"]) ?></p>
                    <p class="m-1 mb-4"><?= chunk_split($adresse["telephone_fact"], 2, " ") ?></p>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>