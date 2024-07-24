<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . '/controller/controller_produit.php');
require_once($root . '/controller/controller_image.php');

$categ = $_GET["categorie"];
$pages = isset($_GET['page']) ? $_GET['page'] : 1;
$limite = 5;

$produits = produitCategorie($categ, $pages, $limite);
$nbr_produit = ceil(nombreProduitParCategorie($categ) / $limite);

$image = imageCategorie($categ);
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
    <link rel="stylesheet" href="css_files/carteCateg.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <title>Catégorie</title>
    <style>
        body {
            background: radial-gradient(ellipse farthest-corner at bottom right, #e0ffff,beige );
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .form-card {
            background-color: rgba(255, 255, 255, 0.9); /* Légère transparence pour laisser entrevoir le fond */
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .pagination .page-link {
            color: #007bff;
        }

        .pagination .page-link:hover {
            color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container form-card text-center">
        <div class="d-flex justify-content-center">
            <img src="<?= $image ?>" alt="image de la catégorie" class="img-fluid">
        </div>
        <br>
        <br>
        <p>DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION <br>DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION</p>
        <br>
        <div class="row justify-content-center m-4">
            <?php foreach ($produits as $produit) { ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="/pages/produits.php?id_produit=<?= $produit['id_produit'] ?>" class="card text-decoration-none text-dark">
                        <img src="<?= $produit["image_produit"] ?>" alt="image du produit" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?= $produit["nom"] ?></h5>
                            <p class="card-text"><?= $produit["prix"] ?> €</p>
                        </div>
                    </a>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
