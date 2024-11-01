<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . '/controller/controller_categorie.php');
require_once($root . '/controller/controller_produit.php');

session_start();
if (isset($_SESSION["id_client"])) {
    $id_client = $_SESSION["id_client"];
    echo $id_client;

}


$categories = categorieAccueil();
$produits = produitAccueil();
$images = produitCarrousel();

?>
<!DOCTYPE html>
<html lang="fr">
<?php
    require_once '../menu/menu.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css_files/navbar.css">
    <link rel="stylesheet" href="css_files/carrousel.css">
    <link rel="stylesheet" href="css_files/carteCateg.css">
    <link rel="stylesheet" href="css_files/accueil.css">

    <script src="js_files/carrousel.js"></script>
    <title>Airneis</title>
</head>

<body>

    <div style="margin-right: 10%; margin-left: 10%;" class="d-flex justify-content-center m-4">
        <div class="col-10">
            <?php include 'misc/carrousel_accueil.php' ?>
        </div>
    </div>
    <div class="text-center m-4">
        <h3 class="m-0">Venant des hautes terres d'écosse</h3>
        <h3>Nos meubles sont immortels</h3>
    </div>
    <h2 class="text-center">CATEGORIES</h2>
    <div class="row justify-content-center m-4">
        <?php foreach ($categories as $categorie) { ?>
            <div class="col-3 m-3">
                <a href="/pages/categorie.php?categorie=<?= $categorie["categorie"] ?>" class="card">

                <?php if ($categorie["categorie"] == "table basse") { ?>
                    <img src="../images/categorie/table-basse-chene-huile.jpg" alt="Table basse chêne huilé">

                <?php } elseif ($categorie["categorie"] == "canapé") { ?>
                    <img src="../images/categorie/canape.png" alt="canapé">   
                    
                <?php } elseif ($categorie["categorie"] == "lit") { ?>
                    <img src="../images/categorie/lit.jpg" alt="canapé">   

                <?php } elseif ($categorie["categorie"] == "chaise") { ?>
                    <img src="../images/categorie/chaise.jpg" alt="Chaise">

                <?php } elseif ($categorie["categorie"] == "lampe") { ?>
                    <img src="../images/categorie/lampe.jpg" alt="lampe">
                
                <?php } elseif ($categorie["categorie"] == "décoration") { ?>
                    <img src="../images/categorie/decoration.jpg" alt="décoration">

                <?php } elseif ($categorie["categorie"] == "bibliothèque") { ?>
                    <img src="../images/categorie/bibliotheque .jpg" alt="Bibliotheque">
                
                <?php } else { ?>

                    <img src="<?= $categorie['img_categ'] ?>" alt="<?= ucfirst($categorie["categorie"]) ?>">
                <?php } ?>
                    <h2 class="product-name"><?= ucfirst($categorie["categorie"]) ?></h2>
                </a>
            </div>
        <?php } ?>
    </div>

    <h2>Les Highlanders du moment</h2>
    <div class="row justify-content-start m-4">

        <?php foreach ($produits as $produit) { ?>
            <div class="col-3 m-3">
                <a href="/pages/produits.php?id_produit=<?= $produit["id_produit"] ?>" class="card">
                    <img src="../images/categorie/double_fuank.jpg" alt="double fuank">
                    <h2 class="product-name"><?= ucfirst($produit["nom"]) ?></h2>
                </a>
            </div>
        <?php } ?>
    </div>
</body>

</html>