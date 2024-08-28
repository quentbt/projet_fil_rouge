<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . '/controller/controller_produit.php');
require_once($root . '/controller/controller_image.php');
require_once($root . '/controller/controller_categorie.php');

$categ = $_GET['categorie'];
$pages = isset($_GET['page']) ? $_GET['page'] : 1;
$limite = 5;

$prix_min = isset($_GET['prix_min']) ? $_GET['prix_min'] : 0;
$prix_max = isset($_GET['prix_max']) ? $_GET['prix_max'] : 999999999;
$mat = isset($_GET['materiaux']) ? (is_array($_GET['materiaux']) ? $_GET['materiaux'] : explode(',', $_GET['materiaux'])) : [];

if (isset($_GET["filtre_produit"])) {

    $prix_min = isset($_GET['prix_min']) ? $_GET['prix_min'] : 0;
    $prix_max = isset($_GET['prix_max']) ? $_GET['prix_max'] : 999999999;
    $mat = isset($_GET['materiaux']) ? (is_array($_GET['materiaux']) ? $_GET['materiaux'] : explode(',', $_GET['materiaux'])) : [];
    $produits = filtre_produit($prix_min, $prix_max, $mat, $categ);
    $total_produits = is_array($produits) ? count($produits) : 0;
    $nbr_produit = ceil($total_produits / $limite);
} else {

    $produits = produitCategorie($categ, $pages, $limite);
    $nbr_produit = ceil(nombreProduitParCategorie($categ) / $limite);
}

$materiaux = allMateriaux();

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
    <link rel="stylesheet" href="css_files/categorie.css">
    <title>Catégorie</title>
</head>

<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <form method="GET">
            <button type="submit" class="button_submit" name="filtre_produit">RECHERCHER</button>
            <?php if (isset($_GET["filtre_produit"])) { ?>
                <a href="/pages/categorie.php?categorie=<?= $categ ?>"><button>Supprimer filtres</button></a>
            <?php } ?>
            <br>
            <br>
            <label for="prix">Prix : </label>
            <div class="row">
                <input type="hidden" name="categorie" value="<?= $categ ?>">
                <input type="number" placeholder="min" pattern="\d*" class="form-control" name="prix_min" value="<?= (isset($_GET["prix_min"])) ? $_GET["prix_min"] : 0 ?>">
                <input type=" number" placeholder="max" pattern="\d*" class="form-control" name="prix_max" value="<?= (isset($_GET["prix_max"])) ? $_GET["prix_max"] : 999999999 ?>">
            </div>
            <br>
            <br>
            <label for="materiaux">Matériaux :</label>
            <br>
            <div id="materiaux-container">
                <?php foreach ($materiaux as $materiel) { ?>
                    <label class="materiel-item">
                        <input type="checkbox" name="materiaux[]" value="<?= $materiel['id_materiaux']; ?>" <?= in_array($materiel['id_materiaux'], $mat) ? 'checked' : '' ?>>
                        <span><?= $materiel["materiaux"] ?></span>
                    </label>
                <?php } ?>
            </div>
        </form>
    </div>

    <span class="openbtn" onclick="openNav()">&#9776;</span>

    <div class="content">
        <div class="d-flex justify-content-center">
            <img src="<?= $image ?>" alt="image de la catégorie">
        </div>
        <br>
        <br>
        <p class="text-center">DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION <br>DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION</p>
        <br>
        <div class="row justify-content-center m-4">

            <?php foreach ($produits as $produit) { ?>
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
                    <a class="page-link" href="/pages/categorie.php?categorie=<?= urlencode($categ) ?>&page=1<?= isset($prix_min) ? '&prix_min=' . urlencode($prix_min) : '' ?><?= isset($prix_max) ? '&prix_max=' . urlencode($prix_max) : '' ?><?= !empty($mat) ? '&materiaux=' . implode(',', array_map('urlencode', $mat)) : '' ?><?= isset($_GET["filtre_produit"]) ? '&filtre_produit=1' : '' ?>">&laquo;</a>
                </li>
                <?php for ($i = 1; $i <= $nbr_produit; $i++) { ?>
                    <li class="page-item <?= $pages == $i ? 'active' : '' ?>">
                        <a class="page-link" href="/pages/categorie.php?categorie=<?= urlencode($categ) ?>&page=<?= $i ?><?= isset($prix_min) ? '&prix_min=' . urlencode($prix_min) : '' ?><?= isset($prix_max) ? '&prix_max=' . urlencode($prix_max) : '' ?><?= !empty($mat) ? '&materiaux=' . implode(',', array_map('urlencode', $mat)) : '' ?><?= isset($_GET["filtre_produit"]) ? '&filtre_produit=1' : '' ?>"><?= $i ?></a>
                    </li>
                <?php } ?>
                <li class="page-item <?= $pages == $nbr_produit ? 'disabled' : '' ?>">
                    <a class="page-link" href="/pages/categorie.php?categorie=<?= urlencode($categ) ?>&page=<?= $nbr_produit ?><?= isset($prix_min) ? '&prix_min=' . urlencode($prix_min) : '' ?><?= isset($prix_max) ? '&prix_max=' . urlencode($prix_max) : '' ?><?= !empty($mat) ? '&materiaux=' . implode(',', array_map('urlencode', $mat)) : '' ?><?= isset($_GET["filtre_produit"]) ? '&filtre_produit=1' : '' ?>">&raquo;</a>
                </li>
            </ul>
        </div>
        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "200px";
                document.querySelector(".content").style.marginLeft = "200px";
                document.querySelector(".openbtn").style.display = "none"; // Cache le bouton "Ouvrir"
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
                document.querySelector(".content").style.marginLeft = "60px";
                document.querySelector(".openbtn").style.display = "block"; // Affiche le bouton "Ouvrir"
            }
        </script>
</body>

</html>