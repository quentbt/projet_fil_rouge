<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . "/controller/controller_produit.php");
$produits = allProduit();

// PAGE IMPOSSIBLE D'ACCES SI L'UTILISATEUR N'EST PAS ADMIN.
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="css_files/table_back.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <title>backOffice Produit</title>
</head>

<style>
        body {
            background: radial-gradient(ellipse farthest-corner at bottom right, #e0ffff,beige );
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .form-card {
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form__field {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form__label {
            position: absolute;
            top: 10px;
            left: 10px;
            transition: transform 0.2s ease-out, font-size 0.2s ease-out, color 0.2s ease-out;
        }

        .form__group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form__field:focus {
            outline: none;
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .table thead th {
            text-align: center;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .container_checkbox {
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container form-card">
        <br>
        <br>
        <form method="POST" action="../controller/controller_formulaire.php">
            <table class="table table-hover" id="tableau_produit">
                <thead>
                    <tr>
                        <th scope="col">
                            <div class="container_checkbox">
                                <input type="checkbox" name="allProduits" id="tout" class="form-check-input">
                                <label for="tout">ID Produit</label>
                            </div>
                        </th>
                        <th scope="col">Nom</th>
                        <th scope="col">Prix (en €)</th>
                        <th scope="col">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits as $produit) { ?>
                        <tr>
                            <td>
                                <div class="container_checkbox">
                                    <input type="checkbox" id="<?= $produit["id_produit"] ?>" name="id_produit[]" class="form-check-input" value="<?= $produit["id_produit"] ?>" />
                                    <label for="<?= $produit["id_produit"] ?>"><?= $produit["id_produit"] ?></label>
                                </div>
                            </td>
                            <td><a style="text-decoration: none; color:black" href="modif_produit.php?id_produit=<?= $produit["id_produit"] ?>"><?= $produit["nom"] ?></a></td>
                            <td><?= $produit["prix"] ?></td>
                            <td><?= $produit["stock"] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <br>
            <div class="row">
                <div class="col-4">
                    <a href="/pages/ajouter_produit.php">
                        <button class="btn btn-primary" id="bouton-ajouter" type="button">Ajouter Produit</button>
                    </a>
                </div>
                <div class="col-8 text-end">
                    <button type="submit" name="produit_carrousel_accueil" class="btn btn-primary" disabled>Mettre dans le carrousel</button>
                    <button type="submit" name="produit_highlander" class="btn btn-primary" id="bouton_highlander" disabled>Mettre produit en avant</button>
                    <button id="bouton-supprimer" type="submit" class="btn btn-danger" name="bouton_supprimer_produit" disabled>Supprimer</button>
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
        var boutonCarrousel = document.querySelector("button[name='produit_carrousel_accueil']");
        var boutonSupprimer = document.getElementById("bouton-supprimer");
        var boutonHighlander = document.getElementById("bouton_highlander");
        var toutCheckbox = document.getElementById("tout");
        var checkboxesProduits = document.querySelectorAll("input[name='id_produit[]']");

        function updateButtons() {
            var count = 0;
            var auMoinsUneSelectionnee = false;
            checkboxesProduits.forEach(function(checkbox) {
                if (checkbox.checked) {
                    count++;
                    auMoinsUneSelectionnee = true;
                }
            });

            boutonCarrousel.disabled = count !== 3;
            boutonSupprimer.disabled = !auMoinsUneSelectionnee;
            boutonHighlander.disabled = !auMoinsUneSelectionnee;
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