<?php

require_once "../controller/controller_client.php";
$users = allUser();

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
                            <input type="checkbox" name="allClient" id="tout" class="form-check-input">
                            <label for="allProduits">ID Client</label>
                        </th>
                        <th scope="col">Nom Prenom</th>
                        <th scope="col">Mail</th>
                        <th scope="col">Téléphone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>

                        <tr>
                            <th>
                                <div class="container_checkbox">
                                    <input type="checkbox" id="<?= $user["id_client"] ?>" name="id_client[]" class="form-check-input" value="<?= $user["id_client"] ?>" />
                                    <?= $user["id_client"] ?>
                                </div>
                            </th>
                            <td><a style="text-decoration: none; color:black" href="modif_client.php?id_client=<?= $user["id_client"] ?>"><?= $user["nom"] . " " . $user["prenom"] ?></a></td>
                            <td><?= $user["email"] ?></td>
                            <td><?= $user["telephone"] ?></td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
            <div class="text-end">
                <button id="bouton-supprimer" type="submit" class="btn btn-danger" name="bouton_supprimer_client" disabled>Supprimer</button>
            </div>
        </form>
    </div>

    <script>
        var boutonCarrousel = document.querySelector("button[name='produit_carrousel_accueil']");
        var checkboxesProduits = document.querySelectorAll("input[name='id_client[]']");

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
            } else {
                boutonSupprimer.disabled = true;
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