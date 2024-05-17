<?php

require_once "../controller/controller_panier.php";
require_once "../controller/controller_produit.php";

// $id_client = $_SESSION["id_client"];
$id_client = 1;

$panier = affichePanier($id_client);
$id_panier = maxPanierId($id_client);
$prixTotal = prixQtt($id_panier);
$tva = $prixTotal * (20 / 100);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css_files/panier.css">
    <title>Panier</title>
</head>

<body>
    <h1 class="text-center">Panier</h1>

    <div class="row center">
        <form action="../controller/controller_formulaire.php" method="POST" class="d-flex justify-content-between">
            <input type="hidden" name="id_panier" value="<?= $id_panier ?>">
            <input type="hidden" name="id_client" value="<?= $id_client ?>">
            <div class="col-5">
                <?php foreach ($panier as $pan) {
                    $quantite = quantite($pan["id_produit"]);
                ?>

                    <div class="produit_panier m-4">
                        <div class="col-3">
                            <img src="<?= $pan["image_produit"] ?>" alt="">
                        </div>
                        <div class="col-7 ml-4">
                            <?= $pan["nom"] ?>
                            <br>
                            <?= $pan["description"] ?>
                        </div>
                        <div class="col-2 text-center d-flex flex-column align-items-end">
                            <p><?= $pan["prix"] ?>€</p>
                            <input type="hidden" name="id_produit[]" value="<?= $pan["id_produit"] ?>">
                            <select name="quantite[]" id="qtt">
                                <?php foreach ($quantite as $qtt) { ?>
                                    <option value="<?= "$qtt" ?>" <?= ($qtt === $pan["quantite"]) ? "selected" : "" ?>><?= $qtt ?></option>
                                <?php } ?>
                            </select>
                            <br>
                            <button class="bouton_suppr" type="button" name="bouton_suppr_produit_panier">
                                <span class="material-symbols-outlined">
                                    delete
                                </span>
                            </button>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-5">
                <div class="row">
                    <div class="col-10">TOTAL :</div>
                    <div class="col-2"><?= $prixTotal ?>€</div>
                </div>
                <div class="row tva">
                    <div class="col-10">TVA</div>
                    <div class="col-2"><?= $tva ?>€</div>
                </div>
                <button class="bouton_acheter" type="submit" name="produits_acheter">acheter</button>
            </div>
        </form>
    </div>
</body>

</html>