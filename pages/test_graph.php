<?php

include "../controller/controller_graph.php"

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Back Office</title>
</head>

<body>

    <div class="row m-4">
        <div class="col-4">
            <img src="/images/graph/graphVenteParTemps.png" alt="">
            <form action="../controller/controller_formulaire.php" method="POST">
                <label for="customRange1" class="form-label">Choisissez le nombre de semaine : <span id="rangeValueBar">1</span></label>
                <input type="range" class="form-range" id="semaineBar" name="semaineBar" min="1" max="5" step="1" oninput="updateValue(this.value, 'rangeValueBar')" value="1">
                <button type="submit" name="graphVenteSemaine" class="btn btn-primary">Choisir</button>
            </form>
        </div>
        <div class="col-4">
            <img src="/images/graph/graphVenteParCategorie.png" alt="">
            <form action="../controller/controller_formulaire.php" method="POST">
                <label for="customRange1" class="form-label">Choisissez le nombre de semaine : <span id="rangeValuePie">1</span></label>
                <input type="range" class="form-range" id="semainePie" name="semainePie" min="1" max="5" step="1" oninput="updateValue(this.value, 'rangeValuePie')" value="1">
                <button type="submit" name="graphVenteCategorie" class="btn btn-primary">Choisir</button>
            </form>
        </div>
    </div>
    <script>
        function updateValue(val, id) {
            document.getElementById(id).innerText = val;
        }
    </script>
</body>

</html>