<?php

require_once "../../connexion_bdd/connexion_bdd.php";

$bdd = db_connect();
$sessionId = 1; //$_SESSION["id"];

$userParam = $bdd->prepare("SELECT * FROM clients WHERE id_client = :id");
$userParam->bindParam(":id", $sessionId);

$userParam->execute();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    var_dump($_POST);
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $adresse1 = $_POST["adresse1"];
    $adresse2 = $_POST["adresse2"];
    $ville = $_POST["ville"];
    $code_postal = $_POST["code_postal"];
    $tel = $_POST["tel"];
    $email = $_POST["email"];

    $modifUser = $bdd->prepare("UPDATE clients SET (nom = :nom, prenom = :prenom, adresse1 = :adresse1, adresse2 = :adresse2, ville = :ville, code_postal = :ville, telephone = :tel, email = :mail)");

    $modifUser->bindParam(":nom", $nom);
    $modifUser->bindParam(":prenom", $prenom);
    $modifUser->bindParam(":adresse1", $adresse1);
    $modifUser->bindParam(":adresse2", $adresse2);
    $modifUser->bindParam(":ville", $ville);
    $modifUser->bindParam(":code_postal", $code_postal);
    $modifUser->bindParam(":telephone", $tel);
    $modifUser->bindParam(":email", $email);

    $modifUser->execute();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=$, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css_files/parametre.css">
    <script src="../js_files/param.js"></script>
    <title>Document</title>
</head>

<body>

    <?php

    foreach ($userParam as $user) { ?>

        <div class="center">

            <div class="row">
                <div class="col-6">
                    <label for="nom">Nom :</label>
                    <div class="input-wrapper">
                        <input type="text" class="input_text" name="nom" value="<?= $user["nom"] ?>" disabled>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <label for="nom">Prenom :</label>
                    <div class="input-wrapper">
                        <input type="text" class="input_text" name="prenom" value="<?= $user["prenom"] ?>" disabled>
                    </div>
                </div>
            </div>
            <div class="col-8 mb-4">
                <label for="nom">Adresse 1 :</label>
                <div class="input-wrapper">
                    <input type="text" class="input_text" name="adresse1" value="<?= $user["adresse1"] ?>" disabled>
                </div>
            </div>
            <div class="col-8 mb-4">
                <label for="nom">adresse 2 :</label>
                <div class="input-wrapper">
                    <input type="text" class="input_text" name="adresse2" <?php if (empty($adresse2)) { ?> placeholder="2e Adresse non renseigné" <?php } else { ?> value="<?= $user["adresse2"] ?>" <?php } ?> disabled>
                </div>
            </div>
            <div class="row mb-4 mt-4">
                <div class="col-6">
                    <label for="nom">ville :</label>
                    <div class="input-wrapper">
                        <input type="text" class="input_text" name="ville" value="<?= $user["ville"] ?>" disabled>

                    </div>
                </div>
                <div class="col-6">
                    <label for="nom">Code Postal :</label>
                    <div class="input-wrapper">
                        <input type="text" class="input_text" name="code_postal" value="<?= (empty($user["code_postal"])) ? "code_postal non renseigné" : $user["code_postal"] ?>" disabled>

                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-6">
                    <label for="nom">Téléphone :</label>
                    <div class="input-wrapper">
                        <input type="text" class="input_text" name="tel" value="<?= (empty($user["telephone"])) ? "telephone non renseigné" : $user["telephone"] ?>" disabled>

                    </div>
                </div>
                <div class="col-6">
                    <label for="nom">Email :</label>
                    <div class="input-wrapper">
                        <input type="text" class="input_text" name="mail" <?php if (empty($user["email"])) { ?> placeholder="Email non renseigné" <?php } else { ?> value="<?= $user["email"] ?>" disabled <?php } ?>>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-4">
                    <button type="submit" class="submit-button" name="submit">Sauvegarder</button>
                </div>
                <div class="col-4">
                    <a href="modif_param.php">
                        <button type="submit" class="submit-button" name="submit">Modifier</button>
                    </a>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

</body>

</html>