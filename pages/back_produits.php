<?php

require_once "../controller/controller_produit.php";
$produits = allProduit();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css_files/table_back.css">
    <link rel="stylesheet" href="../css_files/input_checkbox.css">
    <title>backOffice Produit</title>
</head>

<body>
    <div class="container">
        <a href="/pages/ajouter_produit.php">
            <button id="bouton-ajouter" type="button" class="btn btn-primary">Ajouter</button>
        </a>
        <form method="POST">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" name="allProduits" id="tout">
                            <label for="allProduits">ID Produit</label>
                        </th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prix (en €)</th>
                        <th scope="col">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits as $produit) { ?>

                        <tr>
                            <th>
                                <div class="container_checkbox">
                                    <label for="">
                                        <input type="checkbox" id="<?= $produit["id_produit"] ?>" name="produit[]" />
                                        <?= $produit["id_produit"] ?>
                                    </label>
                                </div>
                            </th>
                            <td><a style="text-decoration: none; color: white;" href="modif_produit.php?id_produit=<?= $produit["id_produit"] ?>"><?= $produit["nom"] ?></a></td>
                            <td><?= $produit["prix"] ?></td>
                            <td><?= $produit["stock"] ?></td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </form>
        <button id="bouton-modifier" type="button" class="btn btn-primary" disabled>Modifier</button>
        <button id="bouton-supprimer" type="button" class="btn btn-danger" disabled>Supprimer</button>
    </div>



    <script>
        // Récupérer la case à cocher "tout"
        var checkboxTout = document.getElementById("tout");

        // Récupérer toutes les cases à cocher des produits
        var checkboxesProduits = document.querySelectorAll("input[name='produit[]']");

        // Ajouter un écouteur d'événement de clic à la case à cocher "tout"
        checkboxTout.addEventListener("click", function() {
            // Parcourir toutes les cases à cocher des produits
            checkboxesProduits.forEach(function(checkbox) {
                // Cocher ou décocher en fonction de l'état de la case à cocher "tout"
                checkbox.checked = checkboxTout.checked;
            });
        });
    </script>
    <script>
        // Sélectionner les boutons que vous souhaitez activer ou désactiver
        var boutonModifier = document.getElementById("bouton-modifier");
        var boutonSupprimer = document.getElementById("bouton-supprimer");

        // Ajouter un écouteur d'événement à chaque case à cocher
        checkboxesProduits.forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                // Vérifier si au moins une case à cocher est cochée
                var auMoinsUneSelectionnee = false;
                checkboxesProduits.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        auMoinsUneSelectionnee = true;
                    }
                });

                // Activer ou désactiver les boutons en fonction de la sélection
                if (auMoinsUneSelectionnee) {
                    boutonModifier.disabled = false;
                    boutonSupprimer.disabled = false;
                } else {
                    boutonModifier.disabled = true;
                    boutonSupprimer.disabled = true;
                }
            });
        });
    </script>

</body>

</html>