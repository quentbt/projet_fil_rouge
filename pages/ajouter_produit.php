<?php

require_once "../controller/controller_categorie.php";
require_once "../controller/controller_produit.php";

$categorie = allCategorie();

$materiaux = allMateriaux();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css_files/input_form.css">
    <link rel="stylesheet" href="css_files/form_card.css">
    <title>Ajouter/Créer un nouveau produit</title>
</head>

<body>

    <h1 class="text-center">Ajouter/Créer un nouveau produit</h1>

    <div class="form-card">

        <h2 class="text-center">Information du nouveau produit</h2>
        <form method="POST" enctype="multipart/form-data" action="../controller/controller_formulaire.php">
            <div class="row">
                <div class="col-3">
                    <div class="form__group field m-0">
                        <input type="input" class="form__field" placeholder="Nom" name="nom" id='nom' required />
                        <label for="nom" class="form__label">Nom</label>
                    </div>
                </div>
                <div class="col-7">
                    <div class="form__group field m-0">
                        <input type="input" class="form__field" placeholder="desc" name="desc" id='desc' required />
                        <label for="desc" class="form__label">Description</label>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form__group field m-0">
                        <input type="input" class="form__field" placeholder="piece" name="piece" id='piece' required />
                        <label for="piece" class="form__label">Piece</label>
                    </div>
                </div>
            </div>
            <br>
            <div class="row d-flex justify-content-between">
                <div class="col-3">
                    <div class="form__group field m-0">
                        <input type="input" class="form__field" placeholder="Prix" name="prix" id='prix' pattern="[0-9]*" required />
                        <label for="prix" class="form__label">Prix</label>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form__group field m-0">
                        <input type="input" class="form__field" placeholder="Stock" name="stock" id='stock' pattern="[0-9]*" required />
                        <label for="stock" class="form__label">Stock</label>
                    </div>
                </div>
                <div class="col-3">
                    <label for="categ">Catégorie du produit : </label>
                    <select name="categ" id="categ" class="form-select" required>
                        <option value=""></option>
                        <?php foreach ($categorie as $categ) { ?>
                            <option value="<?= $categ["id_categorie"] ?>"><?= $categ["categorie"] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <br>
            <br>
            <br>
            <p>Quels matériaux composent ce produit ?</p>
            <?php foreach ($materiaux as $mat) { ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="<?= $mat["id_materiaux"] ?>" name="materiaux[]">
                    <label class="form-check-label" for="<?= $mat["materiaux"] ?>"><?= $mat["materiaux"] ?></label>
                </div>
            <?php } ?>
            <br>
            <br>
            <div class="mb-3">
                <label for="formFile" class="form-label">Image référence </label>
                <input class="form-control" type="file" id="formFile" name="image">
            </div>
            <br>
            <br>
            <div class="d-flex justify-content-center">
                <button class="button" type="submit" name="ajouter_produit">
                    <span class="button-text">Ajouter</span>
                    <div class="fill-container"></div>
                </button>
            </div>
        </form>
    </div>
</body>

</html>