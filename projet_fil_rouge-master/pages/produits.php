<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . "/controller/controller_produit.php");
require_once($root . "/controller/controller_image.php");

$id_produit = $_GET['id_produit'];
$id_client = 1;
// $id_client = $_SESSION["id_client"];

//Récupère les images du produit
$images = imageProduit($id_produit);

//Récupère les informations du produit
$produits = infoProduit($id_produit);

//Récupère les matériaux du produit
$materiaux = materiauxProduit($id_produit);

//Récupère aléatoirement 6 produits de la même catégorie que le produit sur la page
$produitSimil = produitSimilaire($id_produit);

// Quantité qu'on peut commander (MAX : 10)
$quantite = quantite($id_produit);

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
    <link rel="stylesheet" href="css_files/page_produits.css">
    <link rel="stylesheet" href="css_files/carteCateg.css">
    <link rel="stylesheet" href="css_files/carrousel.css">
    <title>Page produit</title>
    <style>
        body {
            background: radial-gradient(ellipse farthest-corner at bottom right, #e0ffff, beige);
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .produit_info {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .produit_info img {
            max-width: 100%;
            height: auto;
        }

        .produit_info p {
            margin-bottom: 5px;
        }

        .produit_info select, .produit_info button {
            margin-top: 10px;
        }

        .border-bottom {
            border-bottom: 2px solid #dee2e6;
        }

        .tva {
            color: #888;
        }

        .col-6 {
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

        .panier {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
        }

        .panier:hover {
            background-color: #218838;
        }

        .similar-products .col-3 {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .similar-products .col-3 img {
            max-width: 100%;
            height: auto;
        }

        .similar-products .col-3 h2 {
            font-size: 1.5rem;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="row">

            <div class="col-6">
                <?php include 'misc/carrousel_image.php' ?>
            </div>

            <div class="col-6 produit_info mb-4">
                <?php foreach ($produits as $produit) { ?>
                    <div class="row m-4">
                        <div class="col-3 p-0">
                            <p style="font-size: 2rem;"><?= $produit["prix"] ?> €</p>
                        </div>
                        <div class="col-9 d-flex flex-column align-items-end">
                            <h1 class="mb-0"><?= $produit["nom"] ?></h1>

                            <?php if ($produit["stock"] > 0) { ?>
                                <p class="mb-0"><small>en stock</small></p>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-12 m-4">
                        <p><?= $produit["description"] ?></p>
                        <p>Ce produit est fait à partir de 
                            <?php foreach ($materiaux as $mat) { ?>
                                <?= $mat["materiaux"] . "," ?>
                            <?php } ?>
                        </p>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fugiat, odit aspernatur! Corporis beatae, culpa blanditiis facere, dolore nostrum sequi, tenetur eum perferendis omnis rerum ea praesentium modi natus? Atque, suscipit.</p>
                    </div>
                <?php } ?>

                <form action="/controller/controller_formulaire.php" method="POST">
                    <div class="m-4">
                        <input type="hidden" name="id_produit" value="<?= $produit["id_produit"] ?>">
                        <input type="hidden" name="id_client" value="<?= $id_client ?>">
                        <select name="quantite" id="qtt" class="form-select w-25">
                            <?php foreach ($quantite as $qtt) { ?>
                                <option value="<?= $qtt ?>"><?= $qtt ?></option>
                            <?php } ?>
                        </select>
                        <br>
                        <button type="submit" name="panier" class="panier"><?= ($produit["stock"] > 0) ? "AJOUTER AU PANIER" : "STOCK ÉPUISÉ" ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <h3 class="text-center m-4">PRODUIT SIMILAIRE</h3>
    <div class="row justify-content-center m-4 similar-products">
        <?php foreach ($produitSimil as $product) { ?>
            <div class="col-3 m-3">
                <a href="/pages/produits.php?id_produit=<?= $product["id_produit"] ?>" class="card">
                    <img src="<?= $product["image_produit"] ?>" alt="">
                    <h2 class="product-name"><?= $product["nom"] ?></h2>
                </a>
            </div>
        <?php } ?>
    </div>
</body>

</html>
