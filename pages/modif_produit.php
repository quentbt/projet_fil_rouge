<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . '/controller/controller_produit.php');
require_once($root . '/controller/controller_categorie.php');
require_once($root . '/controller/controller_image.php');

session_start();
if (isset($_SESSION["id_client"])) {
    $id_client = $_SESSION["id_client"];
}


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

            // var_dump($id_image, $nom, $tmp, "<br>");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css_files/input_form.css">
    <link rel="stylesheet" href="css_files/form_card.css">
    <link rel="stylesheet" href="css_files/modif_produit.css">
    <title>Modifier information produit</title>
</head>

<body>

    <h1 class="text-center m-4">MODIFIER LES INFORMATIONS DU PRODUIT</h1>

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
                            <label for="name" class="form__label">Description</label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row d-flex justify-content-around">
                    <div class="col-2">
                        <div class="form__group field m-0">
                            <input type="input" class="form__field" placeholder="Prix" value="<?= $prod["prix"] ?>" name="prix" id='prix' required />
                            <label for="nom" class="form__label">Prix</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form__group field m-0">
                            <input type="input" class="form__field" placeholder="Stock" value="<?= $prod["stock"] ?>" name="stock" id='prix' required />
                            <label for="nom" class="form__label">Stock</label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form__group field m-0">
                            <input type="input" class="form__field" placeholder="Piece" value="<?= $prod["piece"] ?>" name="piece" id='piece' required />
                            <label for="nom" class="form__label">Piece</label>
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
                <label for="">Image par défaut actuel : </label>
                <input class="form-control" name="img" type="text" value="<?= $prod["image_produit"] ?>" hidden>
                <img src="<?= $prod["image_produit"] ?>" alt="">
            <?php } ?>

            <br>
            <br>

            <div class="d-flex justify-content-center">
                <button class="button" type="submit" name="modif_produit">
                    <span class="button-text">Modifier</span>
                    <div class="fill-container"></div>
                </button>
            </div>
        </div>
    </form>

    <form method="POST" id="form2" enctype="multipart/form-data">
        <table>
            <thead>
                <tr>
                    <!-- <th scope="col">Ordre Affichage</th> -->
                    <th scope="col">Image</th>
                    <th scope="col">Modifier</th>
                    <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($imageProduit as $img) { ?>
                    <tr>
                        <!-- <td class="text-center"><?= $index ?></td> -->
                        <th scope="row">
                            <img src="/images/<?= $img["nom_image"] ?>" alt="">
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
                <div class="fill-container"></div>
            </button>
        </div>
    </form>
    <br>
    <br>
    <br>
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
            document.getElementById("selectRow").appendChild(selectWrapper); // Ajout à l'intérieur du conteneur flexible
        });
    </script>
</body>

</html>