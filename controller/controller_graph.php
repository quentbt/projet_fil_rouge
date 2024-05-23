<?php

require_once "../connexion_bdd/connexion_bdd.php";

$bdd = db_connect();

function graphVenteParTemps($semaine)
{
    global $bdd;
    $semaine = intval($semaine);

    if ($semaine > 1) {

        $requete = $bdd->prepare("SELECT WEEK(date_achat) as date_achat,COUNT(id_historique) as nbr_achat FROM historique WHERE date_achat > DATE(NOW()) - INTERVAL :semaine WEEK GROUP BY WEEK(date_achat)");
        $requete->bindParam(":semaine", $semaine);
        $requete->execute();
    } else {

        $requete = $bdd->query("SELECT DATE(date_achat) as date_achat, COUNT(id_historique) as nbr_achat FROM historique WHERE date_achat >= DATE(NOW()) - INTERVAL 7 DAY GROUP BY DATE(date_achat)");
    }

    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    $nbr_achat = array();
    $dates = array();

    $year = date('Y');

    foreach ($resultat as $result) {

        $nbr_achat[] = $result['nbr_achat'];

        if ($semaine > 1) {

            $startOfWeek = strtotime($year . "W" . str_pad($result["date_achat"], 2, '0', STR_PAD_LEFT));
            $endOfWeek = strtotime("+6 days", $startOfWeek);
            $premierJourSemaine =  date("d M Y", $startOfWeek);
            $dernierJourSemaine = date("d M Y", $endOfWeek);
            $label = $premierJourSemaine . " -\n" . $dernierJourSemaine;
            $dates[] = $label;
        } else {

            $dates[] = $result["date_achat"];
        }
    };

    return [
        "dates" => $dates,
        "nbr_achat" => $nbr_achat
    ];

    header("Location: /pages/test_graph.php");
}

function graphVenteParCategorie($semaine)
{

    global $bdd;

    $dataHist = $bdd->prepare("SELECT c.categorie, COUNT(*) as nombre FROM historique h JOIN panier_produit p_pr ON h.id_panier = p_pr.id_panier JOIN produits pr ON p_pr.id_produit = pr.id_produit JOIN categories c ON pr.categorie = c.id_categorie WHERE h.date_achat >= DATE(NOW()) - INTERVAL :min_date WEEK GROUP BY pr.categorie");
    $dataHist->bindParam(":min_date", $semaine);
    $dataHist->execute();
    $resultat = $dataHist->fetchAll(PDO::FETCH_ASSOC);

    $categorie = array();
    $nbr_produit = array();
    foreach ($resultat as $result) {

        $categorie[] = $result["categorie"];
        $nbr_produit[] = $result["nombre"];
    }

    return [
        "categorie" => $categorie,
        "nbr_achat" => $nbr_produit
    ];
}

function multiBarChart($semaine)
{
    global $bdd;
}
