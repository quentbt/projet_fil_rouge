<?php

require_once "../../connexion_bdd/connexion_bdd.php";

$bdd = db_connect();

session_start();
if (isset($_SESSION["id_client"])) {
    $id_client = $_SESSION["id_client"];
}

$userParam = $bdd->prepare("SELECT * FROM clients WHERE id_client = :id");
$userParam->bindParam(":id", $sessionId);

$userParam->execute();


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $adresse1 = $_POST["adresse1"];
    $adresse2 = $_POST["adresse2"];
    $ville = $_POST["ville"];
    $code_postal = $_POST["code_postal"];
    $tel = $_POST["tel"];
    $email = $_POST["mail"];

    $modifUser = $bdd->prepare("UPDATE clients SET nom = :nom, prenom = :prenom, adresse1 = :adresse1, adresse2 = :adresse2, ville = :ville, code_postal = :code_postal, telephone = :tel, email = :mail WHERE id_client = :id");

    $modifUser->bindParam(":nom", $nom);
    $modifUser->bindParam(":prenom", $prenom);
    $modifUser->bindParam(":adresse1", $adresse1);
    $modifUser->bindParam(":adresse2", $adresse2);
    $modifUser->bindParam(":ville", $ville);
    $modifUser->bindParam(":code_postal", $code_postal);
    $modifUser->bindParam(":tel", $tel);
    $modifUser->bindParam(":mail", $email);
    $modifUser->bindParam(":id", $sessionId);

    $modifUser->execute();

    header("Location : /pages/parametre/parametre.php");
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
    <title>Document</title>
</head>

<body>

    <?php

    foreach ($userParam as $user) { ?>

        <div class="center">
            <form method="POST" id="modifUser">
                <div class="row">
                    <div class="col-6">
                        <label for="nom">Nom :</label>
                        <div class="input-wrapper">
                            <input type="text" class="input_text" name="nom" value="<?= $user["nom"] ?>">
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <label for="nom">Prenom :</label>
                        <div class="input-wrapper">
                            <input type="text" class="input_text" name="prenom" value="<?= $user["prenom"] ?>">
                        </div>
                    </div>
                </div>
                <div class="col-8 mb-4">
                    <label for="nom">Adresse 1 :</label>
                    <div class="input-wrapper">
                        <input type="text" class="input_text" name="adresse1" value="<?= $user["adresse1"] ?>">
                    </div>
                </div>
                <div class="col-8 mb-4">
                    <label for="nom">adresse 2 :</label>
                    <div class="input-wrapper">
                        <input type="text" class="input_text" name="adresse2" <?php if (empty($adresse2)) { ?> placeholder="2e adresse non renseigné" <?php } else { ?> value="<?= $user["adresse2"] ?>" <?php } ?>>
                    </div>
                </div>
                <div class="row mb-4 mt-4">
                    <div class="col-6">
                        <label for="nom">ville :</label>
                        <div class="input-wrapper">
                            <input type="text" class="input_text" name="ville" value="<?= (empty($user["ville"])) ? "Ville non renseigné" : $user["ville"] ?>">

                        </div>
                    </div>
                    <div class="col-6">
                        <label for="nom">Code Postal :</label>
                        <div class="input-wrapper">
                            <input type="text" class="input_text" name="code_postal" value="<?= (empty($user["code_postal"])) ? "code_postal non renseigné" : $user["code_postal"] ?>">

                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-6">
                        <label for="nom">Téléphone :</label>
                        <div class="input-wrapper">
                            <input type="text" class="input_text" name="tel" value="<?= (empty($user["telephone"])) ? "telephone non renseigné" : $user["telephone"] ?>">

                        </div>
                    </div>
                    <div class="col-6">
                        <label for="nom">Email :</label>
                        <div class="input-wrapper">
                            <input type="text" class="input_text" name="mail" value="<?= $user["email"] ?>">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-4">
                        <button type="submit" class="submit-button" name="submit">Sauvegarder</button>
                    </div>
                </div>
            </form>
        </div>
    <?php
    }
    ?>

</body>

</html>