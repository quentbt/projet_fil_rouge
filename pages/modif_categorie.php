<?php

require_once "../controller/controller_categorie.php";
$categorie = allCategorie();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css_files/input_form.css">
    <title>Modifier l'image de présentation d'une catégorie</title>
</head>

<body>
    <h1 class="text-center m-4">MODIFIER CATEGORIE</h1>

    <form method="post" enctype="multipart/form-data" action="/controller/controller_formulaire.php">
        <div class="center">
            <div class="row m-4">
                <div class="col-3">
                    <label for="categorie">Chosissez un produit :</label>
                </div>

                <div class="col-9">
                    <select name="categorie" class="form-select">
                        <?php foreach ($categorie as $categ) { ?>
                            <option value="<?= $categ["categorie"] ?>"><?= $categ["categorie"] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="formFile" class="form-label">Choisissez une image</label>
                <input class="form-control" type="file" id="formFile" name="image">
            </div>

            <br>
            <br>
            <p>Modifier le nom de la catégorie si besoin : </p>
            <div class="form__group field m-0">
                <input type="input" class="form__field" placeholder="Nouveau nom" name="new_name" id='name' />
                <label for="name" class="form__label">Nouveau nom</label>
            </div>

            <br>
            <br>

            <button class="button" type="submit" name="modif_categ">
                <span class="button-text">Modifier</span>
                <div class="fill-container"></div>
            </button>
        </div>
    </form>

    <br>
    <br>
    <br>
    <br>
    <br>

    <h2 class="text-center">ORDRE D'AFFICHAGE DES CATEGORIES</h2>

    <div class="center">
        <form method="POST" action="/controller/controller_formulaire.php">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">categorie</th>
                        <th scope="col" class=" text-center">ordre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorie as $categ) { ?>
                        <tr>
                            <th scope="row"><?= $categ["id_categorie"] ?></th>
                            <td><?= $categ["categorie"] ?></td>
                            <td class="text-center">
                                <input type="hidden" value="<?= $categ["id_categorie"] ?>" name="id_categorie[]">
                                <input type="text" value="<?= $categ["ordre"] ?>" name="ordre[]">
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br>
            <button class="button" type="submit" name="ordreCateg">
                <span class="button-text">Modifier</span>
                <div class="fill-container"></div>
            </button>
        </form>
    </div>
</body>

</html>