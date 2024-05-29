<?php

require_once "../controller/controller_produit.php";
$produits = allProduit();

// PAGE IMPOSSIBLE D'ACCES SI L'UTILISATEUR N'EST PAS ADMIN.
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
    <title>backOffice Produit</title>
</head>

<body>
    <div class="container">
        <a href="/pages/ajouter_produit.php">
            <button id="bouton-ajouter" type="button" class="btn btn-primary">Ajouter</button>
        </a>
        <br>
        <br>
        <form method="POST" action="../controller/controller_formulaire.php">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" name="allProduits" id="tout" class="form-check-input">
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
                                    <input type="checkbox" id="<?= $produit["id_produit"] ?>" name="id_produit[]" class="form-check-input" value="<?= $produit["id_produit"] ?>" />
                                    <?= $produit["id_produit"] ?>
                                </div>
                            </th>
                            <td><a style="text-decoration: none; color:black" href="modif_produit.php?id_produit=<?= $produit["id_produit"] ?>"><?= $produit["nom"] ?></a></td>
                            <td><?= $produit["prix"] ?></td>
                            <td><?= $produit["stock"] ?></td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
            <div class="text-end">
                <button type="submit" name="produit_carrousel_accueil" class="btn btn-primary" disabled>Mettre dans le carrousel</button>
                <button type="submit" name="produit_highlander" class="btn btn-primary" id="bouton_highlander" disabled>Mettre produit en avant</button>
                <button id="bouton-supprimer" type="submit" class="btn btn-danger" name="bouton_supprimer_produit" disabled>Supprimer</button>
            </div>
        </form>
    </div>

    <script>
        var boutonCarrousel = document.querySelector("button[name='produit_carrousel_accueil']");
        var checkboxesProduits = document.querySelectorAll("input[name='id_produit[]']");

        function updateButtons() {
            var count = 0;
            checkboxesProduits.forEach(function(checkbox) {
                if (checkbox.checked) {
                    count++;
                }
            });

            boutonCarrousel.disabled = count !== 3;
        }

        checkboxesProduits.forEach(function(checkbox) {
            checkbox.addEventListener("change", updateButtons);
        });

        updateButtons();
    </script>

    <script>
        var boutonSupprimer = document.getElementById("bouton-supprimer");
        var boutonHighlander = document.getElementById("bouton_highlander");
        var toutCheckbox = document.getElementById("tout");

        function updateButtons() {
            var auMoinsUneSelectionnee = false;
            checkboxesProduits.forEach(function(checkbox) {
                if (checkbox.checked) {
                    auMoinsUneSelectionnee = true;
                }
            });

            if (auMoinsUneSelectionnee) {
                boutonSupprimer.disabled = false;
                boutonHighlander.disabled = false;
            } else {
                boutonSupprimer.disabled = true;
                boutonHighlander.disabled = true;
            }
        }

        checkboxesProduits.forEach(function(checkbox) {
            checkbox.addEventListener("change", updateButtons);
        });

        toutCheckbox.addEventListener("change", function() {
            var etatToutCheckbox = this.checked;
            checkboxesProduits.forEach(function(checkbox) {
                checkbox.checked = etatToutCheckbox;
            });
            updateButtons();
        });

        updateButtons();
    </script>


</body>

</html>