<?php
require_once '../controller/controller_produit.php';
require_once '../controller/controller_image.php';

$categ = $_GET["categorie"];
$pages = isset($_GET['page']) ? $_GET['page'] : 1;
$limite = 5;

$produits = produitCategorie($categ, $pages, $limite);
$nbr_produit = ceil(nombreProduitParCategorie($categ) / $limite);

$image = imageCategorie($categ);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css_files/carteCateg.css">
    <title>Catégorie</title>
</head>

<body>
    <div>
        <img src="<?= $image ?>" alt="image de la catégorie">
    </div>
    <br>
    <div class="row justify-content-center m-4">

        <?php foreach ($produits as $produit) {
        ?>
            <div class="col-3 m-3">
                <a href="/pages/produits.php?id_produit=<?= $produit['id_produit'] ?>" class="card">
                    <img src="<?= $produit["image_produit"] ?>" alt="image du produit">
                </a>
                <div style="width: 20rem; height: fit-content;" class="d-flex justify-content-between">
                    <span><?= $produit["nom"] ?></span>
                    <span><?= $produit["prix"] ?> €</span>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="d-flex justify-content-center">
        <ul class="pagination">
            <li class="page-item <?= $pages == 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="/pages/categorie.php?categorie=<?= $categ ?>&page=1">&laquo;</a>
            </li>
            <?php for ($i = 1; $i <= $nbr_produit; $i++) { ?>
                <li class="page-item <?= $pages == $i ? 'active' : '' ?>">
                    <a class="page-link" href="/pages/categorie.php?categorie=<?= $categ ?>&page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php } ?>
            <li class="page-item <?= $pages == $nbr_produit ? 'disabled' : '' ?>">
                <a class="page-link" href="/pages/categorie.php?categorie=<?= $categ ?>&page=<?= $nbr_produit ?>">&raquo;</a>
            </li>
        </ul>
    </div>
</body>

</html>