<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . "/controller/controller_panier.php");
require_once($root . "/controller/controller_produit.php");

// $id_client = $_SESSION["id_client"];
$id_client = 1;

$panier = affichePanier($id_client);
$id_panier = maxPanierId($id_client);
$prixTotal = prixQtt($id_panier);
$tva = 0;

?>
<!DOCTYPE html>
<html lang="en">

<?php
    require_once '../menu/menu.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css_files/panier.css">
    <style>
        body {
            background: radial-gradient(ellipse farthest-corner at bottom right, #e0ffff, beige);
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .produit_panier {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .produit_panier img {
            max-width: 100px;
            height: auto;
        }

        .produit_panier p {
            margin-bottom: 5px;
        }

        .produit_panier select, .produit_panier button {
            margin-top: 10px;
        }

        .bouton_suppr_produit_panier {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        .bouton_suppr_produit_panier span {
            font-size: 20px;
        }

        .border-bottom {
            border-bottom: 2px solid #dee2e6;
        }

        .tva {
            color: #888;
        }

        .col-5 {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: black;
        }

        .bouton_acheter {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 20px;
        }

        .bouton_acheter:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Panier</h1>
        <div class="row center">
            <form action="../controller/controller_formulaire.php" method="POST" class="d-flex justify-content-between">
                <input type="hidden" name="id_panier" id="id_panier" value="<?= $id_panier ?>">
                <input type="hidden" name="id_client" value="<?= $id_client ?>">
                <div class="col-5">
                    <?php foreach ($panier as $pan) {
                        $quantite = quantite($pan["id_produit"]);
                    ?>

                        <div class="produit_panier m-4">
                            <div class="row">
                                <div class="col-3">
                                    <img src="<?= $pan["image_produit"] ?>" alt="">
                                </div>
                                <div class="col-7 ml-4">
                                    <p class="h2"><?= $pan["nom"] ?></p>
                                    <br>
                                    <p class="text-truncate"><?= $pan["description"] ?></p>
                                </div>
                                <div class="col-2 text-center d-flex flex-column align-items-end">
                                    <p class="h3"><?= $pan["prix"] ?>€</p>
                                    <input type="hidden" name="id_produit[]" id="id_produit" value="<?= $pan["id_produit"] ?>">
                                    <select class="select_quantite" name="quantite_panier[]" id="qtt" data-id_produit="<?= $pan["id_produit"] ?>" data-id_panier="<?= $id_panier ?>">
                                        <?php foreach ($quantite as $qtt) { ?>
                                            <option value="<?= "$qtt" ?>" <?= ($qtt === $pan["quantite"]) ? "selected" : "" ?>><?= $qtt ?></option>
                                        <?php } ?>
                                    </select>
                                    <br>
                                    <button class="bouton_suppr_produit_panier" type="button" data-id_produit="<?= $pan["id_produit"] ?>" data-id_panier="<?= $id_panier ?>" name="bouton_suppr_produit_panier">
                                        <span class="material-symbols-outlined">
                                            delete
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php
                        $tva += ($pan["prix"] * $pan["quantite"]) * (20 / 100);
                    } ?>
                </div>
                <div class="col-5">
                    <div class="border-bottom">
                        <div class="row m-2 h5">
                            <div class="col-10">TOTAL :</div>
                            <div class="col-2 text-end"><?= $prixTotal ?>€</div>
                        </div>
                        <div class="row tva m-2 h6 mb-4">
                            <div class="col-10">TVA :</div>
                            <div class="col-2 text-end"><?= $tva ?>€</div>
                        </div>
                    </div>
                    <button class="bouton_acheter" type="submit" name="produits_acheter">Acheter</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".bouton_suppr_produit_panier").click(function(e) {
                e.preventDefault();

                // Récupérez l'ID du produit que vous souhaitez supprimer ainsi que l'id du panier
                var id_produit = $(this).data("id_produit");
                var id_panier = $(this).data("id_panier");

                console.log('id_produit:', id_produit);
                console.log('id_panier:', id_panier);

                $.ajax({
                    url: '/controller/controller_formulaire.php',
                    type: 'post',
                    data: {
                        'id_produit': id_produit,
                        'id_panier': id_panier
                    },
                    success: function(result) {
                        console.log('Success', result);
                        window.location.href = "/pages/panier.php";
                    },
                    error: function(err) {
                        console.log("Error: ", err);
                    },
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#qtt').change(function() {
                var newQuantity = $(this).val();
                var id_produit = $(this).data("id_produit");
                var id_panier = $(this).data("id_panier");

                console.log(newQuantity, id_produit, id_panier)
                $.ajax({
                    url: '/controller/controller_formulaire.php',
                    type: 'POST',
                    data: {
                        quantity: newQuantity,
                        id_produit: id_produit,
                        id_panier: id_panier
                    },
                    success: function(data) {
                        alert('La quantité a été mise à jour avec succès !');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Une erreur est survenue lors de la mise à jour de la quantité : ' + textStatus + ' ' + errorThrown);
                    }
                });
            });
        });
    </script>
</body>

</html>
