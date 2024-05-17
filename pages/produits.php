<?php
require_once "../controller/controller_produit.php";
require_once "../controller/controller_image.php";

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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css_files/page_produits.css">
    <link rel="stylesheet" href="css_files/carteCateg.css">
    <link rel="stylesheet" href="css_files/carrousel.css">
    <script src="/pages/js_files/carrousel.js"></script>
    <title>Page produit</title>
</head>

<body>
    <div class="row mt-4">

        <div class="col-6">
            <?php include 'misc/carrousel.php' ?>
        </div>

        <div class="col-6 mb-4">
            <?php
            foreach ($produits as $produit) { ?>

                <div class="row m-4">
                    <div class="col-3 p-0">
                        <p style="font-size: 2rem;"><?= $produit["prix"] ?> €</p>
                    </div>
                    <div class="col-9 d-flex flex-column align-items-end">
                        <h1 class="mb-0"><?= $produit["nom"] ?></h1>

                        <?php
                        if ($produit["stock"] > 0) { ?>
                            <p class="mb-0"><small>en stock</small></p>
                        <?php } ?>
                    </div>
                </div>

                <div class="col-12 m-4">
                    <p><?= $produit["description"] ?></p>
                    <p> Ce produit est fait à partir de
                        <?php foreach ($materiaux as $mat) { ?>

                            <?= $mat["materiaux"] . "," ?>


                        <?php } ?>
                    </p>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Fugiat, odit aspernatur! Corporis beatae, culpa blanditiis facere, dolore nostrum sequi, tenetur eum perferendis omnis rerum ea praesentium modi natus? Atque, suscipit.</p>
                </div>
            <?php
            }
            ?>
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

    <h3 class="text-center m-4">PRODUIT SIMILAIRE</h3>
    <div class="row justify-content-center m-4">

        <?php foreach ($produitSimil as $product) { ?>
            <div class="col-3 m-3">
                <a href="/pages/produits/produits.php?id_produit=<?= $product["id_produit"] ?>" class="card">
                    <img src="/images/<?= $product["premiere_image"] ?>" alt="">
                    <h2 class="product-name"><?= $product["nom"] ?></h2>
                </a>
            </div>
        <?php } ?>
    </div>
</body>

</html>