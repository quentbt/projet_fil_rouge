<?php

$root = $_SERVER["DOCUMENT_ROOT"];

require_once($root . '/controller/controller_produit.php');
require_once($root . '/controller/controller_image.php');
require_once($root . '/controller/controller_produit.php');
require_once($root . "/connexion_bdd/connexion_bdd.php");

$image = imageCategorie($categ);
$materiaux = allMateriaux();

if (isset($_POST["filtre_produit"])) {
    if (isset($_POST["materiaux"])) {

        $mat_filtre = $_POST["materiaux"];
        $test = true;

        $sql = "SELECT id_produit FROM `prod_mat` WHERE ";
        for ($i = 0; $i < sizeof($mat_filtre); $i++) {
            if ($test) {
                $sql .= " id_materiaux = " . $mat_filtre[$i];
                $test = false;
            } else {
                $sql .= " AND id_materiaux = " . $mat_filtre[$i];
            }
        }
        $prod_trouve = $bdd->prepare($sql);
        $prod_trouve->execute();
        $produit = $prod_trouve->fetchAll(PDO::FETCH_ASSOC);
        var_dump($sql, $produit);
    }
}


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
        <!-- action="/controller/controller_formulaire.php" -->
        <form method="POST">
            <button type="submit" class="button_submit" name="filtre_produit">RECHERCHER</button>
            <br>
            <br>
            <label for="prix">Prix : </label>
            <div class="row">
                <input type="number" placeholder="min" pattern="\d*" class="form-control" name="prix_min">
                <input type="number" placeholder="max" pattern="\d*" class="form-control" name="prix_max">
            </div>
            <br>
            <br>
            <label for="materiaux">Matériaux :</label>
            <br>
            <div id="materiaux-container">
                <?php foreach ($materiaux as $materiel) { ?>
                    <label class="materiel-item">
                        <input type="checkbox" name="materiaux[]" value="<?= $materiel['id_materiaux']; ?>">
                        <span><?= $materiel["materiaux"] ?></span>
                    </label>
                <?php } ?>
            </div>
        </form>
    </div>

    <span class="openbtn" onclick="openNav()">&#9776;</span>

    <div class="content">
        <?= $sql ?>
        <div class="d-flex justify-content-center">
            <img src="<?= $image ?>" alt="image de la catégorie">
        </div>
        <br>
        <br>
        <p class="text-center">DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION <br>DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION</p>
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