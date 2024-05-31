<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . "/connexion_bdd/connexion_bdd.php");

$bdd = db_connect();

function graphVenteParTemps($semaine)
{
    global $bdd;
    $semaine = intval($semaine);

    if ($semaine > 1) {

        $requete = $bdd->prepare("SELECT YEARWEEK(date_achat, 3) as date_achat,COUNT(id_historique) as nbr_achat FROM historique WHERE date_achat > DATE(NOW()) - INTERVAL :semaine WEEK GROUP BY YEARWEEK(date_achat, 3)");
        $requete->bindParam(":semaine", $semaine);
        $requete->execute();
    } else {

        $requete = $bdd->query("SELECT DATE(date_achat) as date_achat, COUNT(id_historique) as nbr_achat FROM historique WHERE date_achat >= DATE(NOW()) - INTERVAL 7 DAY GROUP BY DATE(date_achat)");
    }

    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    $nbr_achat = array();
    $dates = array();

    foreach ($resultat as $result) {

        $nbr_achat[] = $result['nbr_achat'];

        if ($semaine > 1) {

            $week = substr($result["date_achat"], -2);
            $year = substr($result["date_achat"], 0, 4);
            $startOfWeek = strtotime($year . "W" . str_pad($week, 2, '0', STR_PAD_LEFT));
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

    $dataHist = $bdd->prepare("SELECT c.categorie, COUNT(pp.id_produit) as id_produit, pp.quantite, h.date_achat FROM categories c JOIN produits p ON c.id_categorie = p.categorie JOIN panier_produit pp ON p.id_produit = pp.id_produit JOIN historique h ON pp.id_panier = h.id_panier WHERE date_achat > DATE(NOW()) - INTERVAL :min_date WEEK GROUP BY p.categorie");
    $dataHist->bindParam(":min_date", $semaine);
    $dataHist->execute();
    $resultat = $dataHist->fetchAll(PDO::FETCH_ASSOC);

    $categorie = array();
    $nbr_produit = array();
    foreach ($resultat as $result) {

        $categorie[] = $result["categorie"];
        $nombre = $result["id_produit"] * $result["quantite"];
        $nbr_produit[] = $nombre;
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
