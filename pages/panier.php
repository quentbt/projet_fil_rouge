<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . "/controller/controller_panier.php");
require_once($root . "/controller/controller_produit.php");

session_start();
if (isset($_SESSION["id_client"])) {
    $id_client = $_SESSION["id_client"];
}

echo $id_client;

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css_files/panier.css">

    <script src="https://js.stripe.com/v3/"></script>

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Panier</title>
</head>

<body>
    <h1 class="text-center">Panier</h1>

    <div class="row center">
        <form action="create-checkout-session.php" method="POST" class="d-flex justify-content-between">
            <input type="hidden" name="id_panier" id="id_panier" value="<?= $id_panier ?>">
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
                <?php
                    $tva += ($pan["prix"] * $pan["quantite"]) * (20 / 100);
                } ?>
            </div>
            <div class="col-5">
                <div class="row">
                    <div class="col-10">TOTAL :</div>
                    <div class="col-2"><?= $prixTotal ?>€</div>
                </div>
                <div class="row tva">
                    <div class="col-10">TVA</div>
                    <div class="col-2"><?= $tva ?>€</div>

                <form action="checkout.php" method="POST">
                    <button type="submit" id="checkout-button">Payer</button>
                </form>

                <!-- <button id="checkout-button">Payer avec Stripe</button> -->
        </form>
    </div>

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    var stripe = Stripe('pk_test_51Q51MLGqRZhDnoeODGFovBEMepiHc4qSUzBWoobMprsQsXRLiWXI68qQG0H9UANOCctD7uBnXNzPeuIh5c8XH6Sl00obZln9dC'); // Ta clé publique

    document.getElementById('checkout-button').addEventListener('click', function (e) {
    e.preventDefault();

    // Récupérer les informations à envoyer
    var idPanier = document.getElementById('id_panier').value;
    var idClient = '<?= $id_client ?>'; // Récupère l'ID du client à partir de PHP
    var produits = [];

    // Parcourir chaque produit et ajouter les informations au tableau "produits"
    document.querySelectorAll('.produit_panier').forEach(function (element) {
        var idProduit = element.querySelector('input[name="id_produit[]"]').value;
        var quantite = element.querySelector('select[name="quantite_panier[]"]').value;

        produits.push({
            id_produit: idProduit,
            quantite: quantite
        });
    });

    // Vérifie si les données sont correctement récupérées
    console.log("ID Panier:", idPanier);
    console.log("ID Client:", idClient);
    console.log("Produits:", produits);

    // Envoyer la requête avec les données JSON
    fetch('http://localhost:3000/create-checkout-session.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id_panier: idPanier,
            id_client: idClient,
            produits: produits
        }),
    })
    .then(function (response) {
        return response.json();
    })
    .then(function (session) {
        if (session.id) {
            return stripe.redirectToCheckout({ sessionId: session.id });
        } else {
            console.error('Erreur: ', session.error);
        }
    })
    .catch(function (error) {
        console.error('Erreur lors de la requête Fetch:', error);
    });
});


</script>


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