<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . "/controller/controller_client.php");
$users = allUser();



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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="css_files/table_back.css">
    <title>back office Produit</title>
    
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
<body>

    <div class="container form-card">
        <br>
        <br>
        <form method="POST" action="../controller/controller_formulaire.php">
            <table class="table table-hover" id="tableau_client">
                <thead>
                    <tr>
                        <th scope="col">
                            <div class="container_checkbox">
                                <input type="checkbox" name="allClient" id="tout" class="form-check-input">
                                <label for="tout">ID Client</label>
                            </div>
                        </th>
                        <th scope="col">Nom</th>
                        <th scope="col">Mail</th>
                        <th scope="col">Téléphone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td>
                                <div class="container_checkbox">
                                    <input type="checkbox" id="<?= $user["id_client"] ?>" name="id_client[]" class="form-check-input" value="<?= $user["id_client"] ?>" />
                                    <label for="<?= $user["id_client"] ?>"><?= $user["id_client"] ?></label>
                                </div>
                            </td>
                            <td><a style="text-decoration: none; color:black" href="modif_client.php?id_client=<?= $user["id_client"] ?>"><?= $user["nom"] . " " . $user["prenom"] ?></a></td>
                            <td><?= $user["email"] ?></td>
                            <td><?= chunk_split($user["telephone"], 2, " ") ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="text-end">
                <button id="bouton-supprimer" type="submit" class="btn btn-danger button" name="bouton_supprimer_client" disabled>Supprimer</button>
            </div>
        </form>
    </div>

    <!-- Script du dataTable -->
    <script>
        $(document).ready(function() {
            var table = $('#tableau_client').DataTable({
                "paging": false,
                "retrieve": true
            });
            $('#tableau_client').removeClass('dataTable');

            // On page load, check the checkboxes that were previously checked
            var checkedItems = JSON.parse(localStorage.getItem('checkedItems')) || [];
            checkedItems.forEach(function(id) {
                $('#' + id).prop('checked', true);
            });

            // On checkbox change, update the local storage
            table.on('change', 'input[type="checkbox"]', function() {
                var checkboxId = this.id;
                if (this.checked) {
                    checkedItems.push(checkboxId);
                } else {
                    var index = checkedItems.indexOf(checkboxId);
                    if (index !== -1) {
                        checkedItems.splice(index, 1);
                    }
                }
                localStorage.setItem('checkedItems', JSON.stringify(checkedItems));
            });
        });
    </script>
    <!-- Fin dataTables -->

    <script>
        var toutCheckbox = document.getElementById("tout");
        var checkboxesProduits = document.querySelectorAll("input[name='id_client[]']");
        var boutonSupprimer = document.getElementById("bouton-supprimer");

        function updateButtons() {
            var auMoinsUneSelectionnee = Array.from(checkboxesProduits).some(checkbox => checkbox.checked);
            boutonSupprimer.disabled = !auMoinsUneSelectionnee;
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