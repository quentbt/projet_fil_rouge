<?php

require_once "../connexion_bdd/connexion_bdd.php";
require_once "../jpgraph-4.4.2/src/jpgraph.php";
require_once "../jpgraph-4.4.2/src/jpgraph_bar.php";
require_once "../jpgraph-4.4.2/src/jpgraph_pie.php";

$bdd = db_connect();

function graphVenteParTemps($semaine)
{
    global $bdd;
    $filename = $_SERVER['DOCUMENT_ROOT'] . '/images/graph/graphVenteParTemps.png';
    $minDate = date('Y-m-d', strtotime("-$semaine weeks"));

    $requete = $bdd->prepare("SELECT COUNT(id_historique) AS nbr_achat, DATE(date_achat) AS date_achat FROM historique WHERE date_achat >= :min_date GROUP BY date_achat");
    $requete->bindParam(":min_date", $minDate);
    $requete->execute();

    $y = array();
    $x = array();

    while ($row = $requete->fetch()) {

        $y[] = $row["nbr_achat"];
        $x[] = strtotime($row["date_achat"]);
        $label[] = date('D d M', strtotime($row["date_achat"]));
    }

    var_dump($x, $label);

    if (file_exists($filename)) {
        unlink($filename);
    }

    $graph = new Graph(450, 350);
    $graph->SetScale("intint");
    $graph->SetShadow();

    // X Axis
    $graph->xaxis->SetTitle("Temps", "center");
    $graph->xaxis->SetTickLabels($label);

    // Y Axis
    $graph->yaxis->SetTitle("Nbr de Vente", "center");

    $barPlot = new BarPlot($y);
    $barPlot->SetWidth(20);
    $graph->Add($barPlot);
    $graph->Stroke($filename);

    header("Location: /pages/test_graph.php");
}



function graphVenteCategorie($semaine)
{
    global $bdd;

    $filename = $_SERVER['DOCUMENT_ROOT'] . '/images/graph/graphVenteParCategorie.png';
    $minDate = date('Y-m-d', strtotime("-$semaine weeks"));

    $dataHist = $bdd->prepare("SELECT c.categorie, COUNT(*) as nombre FROM historique h JOIN panier_produit p_pr ON h.id_panier = p_pr.id_panier JOIN produits pr ON p_pr.id_produit = pr.id_produit JOIN categories c ON pr.categorie = c.id_categorie WHERE h.date_achat >= :min_date GROUP BY pr.categorie ORDER BY pr.categorie;");
    $dataHist->bindParam(":min_date", $minDate);
    $dataHist->execute();

    $data = array();
    $label = array();
    while ($row = $dataHist->fetch()) {

        $data[] = $row["nombre"];
        $label[] = $row["categorie"];
    }

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (file_exists($filename)) {

        unlink($filename);
    }

    $graph = new PieGraph(450, 350);

    $graph->SetShadow();

    $graph->title->Set("Vente par catégorie");

    $piePlot = new PiePlot($data);
    $piePlot->SetLegends($label);

    $graph->Add($piePlot);

    $graph->Stroke($filename);

    header("Location: /pages/test_graph.php");
}
