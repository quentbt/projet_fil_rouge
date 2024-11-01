<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . "/controller/controller_client.php");
$users = allUser();

// PAGE IMPOSSIBLE D'ACCES SI L'UTILISATEUR N'EST PAS ADMIN.
?>
<!DOCTYPE html>

<html lang="en">
<?php
    require_once '../../menu/menu.php';
    
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
    <link rel="stylesheet" href="../css_files/table_back.css">
    <link rel="stylesheet" href="css_files/back_client.css">
    <title>back-office Clients</title>
</head>

<body>
    <div class="container">
        <br>
        <br>
        <form method="POST" action="../controller/controller_formulaire.php">
            <table class="table table-hover" id="tableau_client">
                <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" name="allClient" id="tout" class="form-check-input">
                            <label for="allProduits">ID Client</label>
                        </th>
                        <th scope="col">Nom</th>
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
                            <td><?= chunk_split($user["telephone"], 2, " ") ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="text-end">
                <button id="bouton-supprimer" type="submit" class="btn btn-danger" name="bouton_supprimer_client" disabled>Supprimer</button>
            </div>
        </form>
    </div>

    <!-- Script du dataTable -->
    <script>
        $(document).ready(function() {
            $('#tableau_client').DataTable({
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