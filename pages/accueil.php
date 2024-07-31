<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . '/controller/controller_categorie.php');
require_once($root . '/controller/controller_produit.php');

$categories = categorieAccueil();
$produits = produitAccueil();
$images = produitCarrousel();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airneis</title>

   
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
   
    <link rel="stylesheet" href="css_files/navbar.css">
    <link rel="stylesheet" href="css_files/carrousel.css">
    <link rel="stylesheet" href="css_files/carteCateg.css">

    
    <script src="js_files/carrousel.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
</head>

<body>

   
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10">
                <?php include 'misc/carrousel_accueil.php'; ?>
            </div>
        </div>
    </div>

  
    <div class="text-center my-4">
        <h3 class="mb-1">Venant des hautes terres d'Écosse</h3>
        <h3>Nos meubles sont immortels</h3>
    </div>

  
    <div class="container my-4">
        <h2 class="text-center mb-4">Catégories</h2>
        <div class="row justify-content-center">
            <?php foreach ($categories as $categorie) { ?>
                <div class="col-12 col-md-4 col-lg-3 mb-4">
                    <a href="/pages/categorie.php?categorie=<?= urlencode($categorie["categorie"]) ?>" class="card text-decoration-none">
                        <img src="<?= htmlspecialchars($categorie["img_categ"]) ?>" alt="<?= htmlspecialchars($categorie["categorie"]) ?>" class="card-img-top">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= ucfirst(htmlspecialchars($categorie["categorie"])) ?></h5>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

    
    <div class="container my-4">
        <h2 class="mb-4">Les Highlanders du moment</h2>
        <div class="row">
            <?php foreach ($produits as $produit) { ?>
                <div class="col-12 col-md-4 col-lg-3 mb-4">
                    <a href="/pages/produits.php?id_produit=<?= urlencode($produit["id_produit"]) ?>" class="card text-decoration-none">
                        <img src="<?= htmlspecialchars($produit["image_produit"]) ?>" alt="<?= htmlspecialchars($produit["nom"]) ?>" class="card-img-top">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= ucfirst(htmlspecialchars($produit["nom"])) ?></h5>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>

</body>
</html>
