<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . "/controller/controller_categorie.php");
$categorie = allCategorie();
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
    <link rel="stylesheet" href="css_files/input_form.css">
    <title>Modifier l'image de présentation d'une catégorie</title>
    <style>
        body {
            background: radial-gradient(ellipse farthest-corner at bottom right, #e0ffff, beige);
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .form-card {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form__field {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form__label {
            position: absolute;
            top: 10px;
            left: 10px;
            transition: transform 0.2s ease-out, font-size 0.2s ease-out, color 0.2s ease-out;
        }

        .form__group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .table {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-5">MODIFIER CATEGORIE</h1>

        <div class="form-card">
            <form method="post" enctype="multipart/form-data" action="/controller/controller_formulaire.php">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="categorie" class="form-label">Choisissez une catégorie :</label>
                    </div>
                    <div class="col-md-9">
                        <select name="categorie" class="form-select">
                            <?php foreach ($categorie as $categ) { ?>
                                <option value="<?= $categ["categorie"] ?>"><?= $categ["categorie"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3 mt-4">
                    <label for="formFile" class="form-label">Choisissez une nouvelle image :</label>
                    <input class="form-control" type="file" id="formFile" name="image">
                </div>

                <div class="mb-3">
                    <div class="form__group">
                        <input type="text" class="form__field" placeholder="Nouveau nom de la catégorie" name="new_name" id='name' />
                        <label for="name" class="form__label">Nouveau nom de la catégorie</label>
                    </div>
                </div>

                <div class="text-center">
                    <button class="button" type="submit" name="modif_categ">
                        <span class="button-text">Modifier</span>
                    </button>
                </div>
            </form>
        </div>

        <h2 class="text-center mt-5">ORDRE D'AFFICHAGE DES CATEGORIES</h2>

        <div class="form-card">
            <form method="POST" action="/controller/controller_formulaire.php">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Catégorie</th>
                            <th scope="col" class="text-center">Ordre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorie as $categ) { ?>
                            <tr>
                                <th scope="row"><?= $categ["id_categorie"] ?></th>
                                <td><?= $categ["categorie"] ?></td>
                                <td class="text-center">
                                    <input type="hidden" value="<?= $categ["id_categorie"] ?>" name="id_categorie[]">
                                    <input type="text" value="<?= $categ["ordre"] ?>" name="ordre[]" class="form-control">
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <div class="text-center mt-4">
                    <button class="button" type="submit" name="ordreCateg">
                        <span class="button-text">Modifier l'ordre</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
