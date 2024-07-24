<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . "/controller/controller_panier.php");
require_once($root . "/controller/controller_client.php");

$id_panier = $_GET["id_panier"];
$id_client = 1;
$panier = produitCommande($id_panier);
$prixTotal = prixQtt($id_panier);

$tva = 0;
$adresseLivraison = adresseLivraison($id_client);
$adresseFacture = adresseFacturation($id_client);

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
    <link rel="stylesheet" href="css_files/panier.css">
    <title>Détail du panier</title>
    <style>
        body {
            background: radial-gradient(ellipse farthest-corner at bottom right, #e0ffff, beige);
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .produit_panier {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .produit_panier img {
            max-width: 100px;
            height: auto;
        }

        .produit_panier p {
            margin-bottom: 5px;
        }

        .produit_panier select, .produit_panier button {
            margin-top: 10px;
        }

        .bouton_suppr_produit_panier {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: not-allowed;
        }

        .bouton_suppr_produit_panier span {
            font-size: 20px;
        }

        .border-bottom {
            border-bottom: 2px solid #dee2e6;
        }

        .tva {
            color: #888;
        }

        .col-5 {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: black;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-4">Commande n°<?= $id_panier ?></h1>
        <div class="row center d-flex justify-content-between">
            <div class="col-5">
                <?php foreach ($panier as $pan) { ?>
                    <div class="produit_panier m-4">
                        <div class="row">
                            <div class="col-3">
                                <img src="<?= $pan["image_produit"] ?>" alt="">
                            </div>
                            <div class="col-7 ml-4">
                                <p class="h5"><?= $pan["nom"] ?></p>
                                <p><?= $pan["description"] ?></p>
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
    </div>
</body>

</html>
