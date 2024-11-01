<?php

$root = $_SERVER["DOCUMENT_ROOT"];
include($root . "/controller/controller_graph.php");

session_start();
if (isset($_SESSION["id_client"])) {
    $id_client = $_SESSION["id_client"];
}

if (isset($_POST["graphVenteSemaine"])) {
    $semaineBar = $_POST["semaineBar"];
} else {
    $semaineBar = 1;
}

if (isset($_POST['graphVenteCategorie'])) {
    $semainePie = $_POST["semainePie"];
} else {
    $semainePie = 1;
}

// Bar Chart
$dates = graphVenteParTemps($semaineBar)["dates"];
$nbr_achat = graphVenteParTemps($semaineBar)["nbr_achat"];

// Pie Chart
$categorie = graphVenteParCategorie($semainePie)["categorie"];
$nbr_produit = graphVenteParCategorie($semainePie)["nbr_achat"];

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
    <link rel="stylesheet" href="css_files/test_graph.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Graphes</title>
</head>

<body>
    <div class="row m-4 d-flex justify-content-around">
        <div class="col-5">
            <form method="POST">
                <canvas id="myChart"></canvas>
                <label for="customRange1" class="form-label">Choisissez le nombre de semaine : <span id="rangeValueBar"><?= $semaineBar ?></span></label>
                <input type="range" class="form-range" id="semaineBar" name="semaineBar" min="1" max="5" step="1" oninput="updateValue(this.value, 'rangeValueBar')" value="<?= $semaineBar ?>">
                <button type="submit" name="graphVenteSemaine" class="btn btn-primary">Choisir</button>
                <p><small><small>Si aucune donnée pour tel jour ou semaine. C'est qu'il n'y a pas eu d'achat </small></small></p>
            </form>
        </div>
        <div class="col-5">
            <form method="POST">
                <canvas id="myGroupBarChart"></canvas>
                <label for="customRange1" class="form-label">Choisissez le nombre de semaine : <span id="rangeValueGroupBar"><?= $semainePie ?></span></label>
                <input type="range" class="form-range" id="semainePie" name="semainePie" min="1" max="5" step="1" oninput="updateValue(this.value, 'rangeValuePie')" value="<?= $semainePie ?>">
                <button type="submit" name="graphVenteCategorie" class="btn btn-primary">Choisir</button>
            </form>
        </div>
    </div>
    <br><br>
    <div class="d-flex justify-content-center">
        <form method="POST">
            <canvas id="myPieChart"></canvas>
            <label for="customRange1" class="form-label">Choisissez le nombre de semaine : <span id="rangeValuePie">1</span></label>
            <input type="range" class="form-range" id="semainePie" name="semainePie" min="1" max="5" step="1" oninput="updateValue(this.value, 'rangeValuePie')" value="1">
            <button type="submit" name="graphVenteCategorie" class="btn btn-primary">Choisir</button>
        </form>
    </div>

    <!-- BAR CHART -->
    <script>
        $(document).ready(function() {
            $("#semaineBar").on('change', function() {
                var semaineValue = $(this).val();
            });

            function updateChart(dates, nbr_achat) {
                myChart.data.labels = dates;
                myChart.data.datasets[0].data = nbr_achat;
                myChart.update();
            }
        });

        function updateValue(val, id) {
            document.getElementById(id).textContent = val;
        }

        var labelsBar = <?= json_encode($dates) ?>;
        var dataBar = <?= json_encode($nbr_achat) ?>;

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labelsBar,
                datasets: [{
                    label: 'Vente par semaine',
                    data: dataBar,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    maxBarThickness: 50,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <!-- PIE CHART -->
    <script>
        var ctx = document.getElementById('myPieChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?= json_encode($categorie) ?>,
                datasets: [{
                    label: 'Produit vendu par catégorie',
                    data: <?= json_encode($nbr_produit) ?>,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                        'rgb(255, 159, 64)'
                    ],
                    hoverOffset: 4
                }]
            }
        });
    </script>
    <!-- GROUP BAR CHART -->
    <script>
        var ctx = document.getElementById('myGroupBarChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun'],
                datasets: [{
                        label: 'Dataset 1',
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Dataset 2',
                        data: [5, 9, 3, 5, 22, 3],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>