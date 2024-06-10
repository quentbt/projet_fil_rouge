<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . "/controller/controller_categorie.php");
$categories = allCategorie();

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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <title>back-office Produit</title>
</head>

<body>
    <div class="container">
        <br>
        <br>
        <form method="POST" action="/controller/controller_formulaire.php">
            <table class="table table-hover" id="tableau_produit">
                <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" name="allProduits" id="tout" class="form-check-input">
                            <label for="allProduits">ID Catégorie</label>
                        </th>
                        <th scope="col">Nom</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $categorie) { ?>
                        <tr>
                            <th>
                                <div class="container_checkbox">
                                    <input type="checkbox" id="<?= $categorie["id_categorie"] ?>" name="id_categorie[]" class="form-check-input" value="<?= $categorie["id_categorie"] ?>" />
                                    <?= $categorie["id_categorie"] ?>
                                </div>
                            </th>
                            <td><a style="text-decoration: none; color:black" href="/pages/modif_categorie.php?id_categorie=<?= $categorie["id_categorie"] ?>"><?= $categorie["categorie"] ?></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br>
            <div class="row">
                <div class="col-4">
                    <a href="/pages/ajouter_produit.php">
                        <button class="btn btn-primary" id="bouton-ajouter" type="button">Ajouter catégorie</button>
                    </a>
                </div>
                <div class="col-8 text-end">
                    <button type="submit" name="categorie_affiche" class="btn btn-primary" id="categorie_affiche" disabled>Afficher catégorie accueil</button>
                    <button id="bouton-supprimer" type="submit" class="btn btn-danger" name="bouton_supprimer_categorie" disabled>Supprimer</button>
                </div>
            </div>
        </form>
    </div>
    <br><br>
    <!-- Script du dataTable -->
    <script>
        $(document).ready(function() {
            $('#tableau_produit').DataTable({
                "paging": false,
                "retrieve": true
            });
            $('#tableau_produit').removeClass('dataTable');
        });
    </script>
    <!-- Fin dataTables -->

    <script>
        var boutonSupprimer = document.getElementById("bouton-supprimer");
        var boutonAffiche = document.getElementById("categorie_affiche");
        var toutCheckbox = document.getElementById("tout");
        var checkboxesCateg = document.querySelectorAll("input[name='id_categorie[]']");

        function updateButtons() {
            var auMoinsUneSelectionnee = Array.from(checkboxesCateg).some(checkbox => checkbox.checked);

            boutonSupprimer.disabled = !auMoinsUneSelectionnee;
            boutonAffiche.disabled = !auMoinsUneSelectionnee;
        }

        checkboxesCateg.forEach(function(checkbox) {
            checkbox.addEventListener("change", updateButtons);
        });

        toutCheckbox.addEventListener("change", function() {
            var etatToutCheckbox = this.checked;
            checkboxesCateg.forEach(function(checkbox) {
                checkbox.checked = etatToutCheckbox;
            });
            updateButtons();
        });

        updateButtons();
    </script>
</body>

</html>