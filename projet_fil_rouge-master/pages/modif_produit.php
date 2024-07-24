<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . '/controller/controller_produit.php');
require_once($root . '/controller/controller_categorie.php');
require_once($root . '/controller/controller_image.php');

$id_produit = $_GET["id_produit"];

$produit = infoProduit($id_produit);

$imageProduit = imageProduit($id_produit);

$categorie = allCategorie();

$index = 1;

if (isset($_POST["modif_image"])) {
    $id = array();
    foreach ($_POST as $key => $post) {
        $id[] = $post;
    }

    $index = 0;
    foreach ($_FILES as $key => $file) {
        if (!empty($file["name"])) {
            $id_image = $id[$index];
            $nom = $file["name"];
            $tmp = $file["tmp_name"];

            move_uploaded_file($tmp, "../images/" . $nom);

            $updateImg = $bdd->prepare("UPDATE images SET nom_image = :nom WHERE id_image = :id");
            $updateImg->bindParam(":nom", $nom);
            $updateImg->bindParam(":id", $id_image);
            $updateImg->execute();
        }
        $index++;
    }
}
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
    <title>Modifier information produit</title>
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

        .form__label::after {
            content: " *";
            color: red;
        }

        .required {
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="text-center mt-5">MODIFIER LES INFORMATIONS DU PRODUIT</h1>

        <form method="post" id="form1" enctype="multipart/form-data" action="../controller/controller_formulaire.php">
            <div class="form-card">
                <h2 class="text-center">Modifier information du produit</h2>

                <?php foreach ($produit as $prod) { ?>
                    <div class="row m-4">
                        <div class="col-3">
                            <div class="form__group field m-0">
                                <input type="input" class="form__field" placeholder="Nom" value="<?= $prod["nom"] ?>" name="nom" id='nom' required />
                                <label for="nom" class="form__label">Nom</label>
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="form__group field m-0">
                                <input type="input" class="form__field" placeholder="Description" value="<?= $prod["description"] ?>" name="desc" id='desc' required />
                                <label for="desc" class="form__label">Description</label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row d-flex justify-content-around">
                        <div class="col-2">
                            <div class="form__group field m-0">
                                <input type="input" class="form__field" placeholder="Prix" value="<?= $prod["prix"] ?>" name="prix" id='prix' required />
                                <label for="prix" class="form__label">Prix</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form__group field m-0">
                                <input type="input" class="form__field" placeholder="Stock" value="<?= $prod["stock"] ?>" name="stock" id='stock' required />
                                <label for="stock" class="form__label">Stock</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form__group field m-0">
                                <input type="input" class="form__field" placeholder="Piece" value="<?= $prod["piece"] ?>" name="piece" id='piece' required />
                                <label for="piece" class="form__label">Piece</label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <input type="hidden" name="id_produit" value="<?= $id_produit ?>">

                    <div class="mb-3">
                        <label for="formFile" class="form-label">Choisissez une image</label>
                        <input class="form-control" type="file" id="formFile" name="image">
                    </div>
                    <br>
                    <div>
                        <label for="categorie">Catégorie du produit</label>
                        <br>
                        <div class="col-3" id="selectRow">
                            <select name="categorie" class="form-select" required>
                                <option value="defaut"></option>
                                <?php foreach ($categorie as $categ) { ?>
                                    <option value="<?= $categ["id_categorie"] ?>"><?= $categ["categorie"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <br>
                    <label for="">Image par défaut actuel :</label>
                    <input class="form-control" name="img" type="text" value="<?= $prod["image_produit"] ?>" hidden>
                    <img src="<?= $prod["image_produit"] ?>" alt="" style="max-width: 100%; height: auto;">
                <?php } ?>

                <br>
                <br>

                <div class="d-flex justify-content-center">
                    <button class="button" type="submit" name="modif_produit">
                        <span class="button-text">Modifier</span>
                    </button>
                </div>
            </div>
        </form>

        <form method="POST" id="form2" enctype="multipart/form-data">
            <div class="form-card">
                <h2 class="text-center">Modifier les images du produit</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Modifier</th>
                            <th scope="col">Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($imageProduit as $img) { ?>
                            <tr>
                                <th scope="row">
                                    <img src="/images/<?= $img["nom_image"] ?>" alt="" style="max-width: 100px; height: auto;">
                                    <input type="hidden" name="<?= $img["id_image"] ?>" value="<?= $img["id_image"] ?>">
                                </th>
                                <td><input class="form-control" type="file" id="formFile" name="image<?= $img["id_image"] ?>"></td>
                                <td class="text-center"><button class="btn btn-danger">Supprimer</button></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <br><br>
                <div class="d-flex justify-content-center">
                    <button class="button" type="submit" name="modif_image_produit">
                        <span class="button-text">Modifier</span>
                    </button>
                </div>
            </div>
        </form>
        <br>
        <br>
    </div>

    <script>
        document.getElementById("addSelect").addEventListener("click", function() {
            var selectWrapper = document.createElement("div");
            selectWrapper.className = "select-wrapper";
            var select = document.createElement("select");
            select.className = "form-select";
            select.name = "categorie";
            <?php foreach ($categorie as $categ) { ?>
                var option = document.createElement("option");
                option.value = "<?= $categ["id_categorie"] ?>";
                option.textContent = "<?= $categ["categorie"] ?>";
                select.appendChild(option);
            <?php } ?>
            selectWrapper.appendChild(select);
            document.getElementById("selectRow").appendChild(selectWrapper);
        });
    </script>
</body>

</html>
