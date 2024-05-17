<?php

require_once '../connexion_bdd/connexion_bdd.php';
require_once '../controller/controller_produit.php';

$bdd = db_connect();

function maxPanierId($id_client)
{
    global $bdd;

    $panierClient = $bdd->prepare("SELECT MAX(id_panier) FROM panier WHERE id_client = :id_client");
    $panierClient->bindParam(":id_client", $id_client);
    $panierClient->execute();
    $id = $panierClient->fetchColumn();

    if (!isset($id)) {

        $id = 1;
    }

    return $id;
}

function createPanier($id_client)
{
    global $bdd;
    $id = maxPanierId($id_client);

    $creationPanierClient = $bdd->prepare("INSERT INTO panier VALUES (:id_panier, :id_client)");
    $creationPanierClient->bindParam(":id_panier", $id);
    $creationPanierClient->bindParam(":id_client", $id_client);
    $creationPanierClient->execute();
}

function affichePanier($id_client)
{
    global $bdd;

    $panier = maxPanierId($id_client);
    $produitPanier = $bdd->query("SELECT produits.*, panier_produit.* FROM produits LEFT JOIN panier_produit ON produits.id_produit = panier_produit.id_produit WHERE produits.id_produit = panier_produit.id_produit");
    $panier = $produitPanier->fetchAll(PDO::FETCH_ASSOC);

    return $panier;
}

function insertPanier($id_produit, $quantite, $id_client)
{
    global $bdd;
    $id_panier = maxPanierId($id_client);

    $nouveauProduitPanier = $bdd->prepare("INSERT INTO panier_produit VALUES (:id_panier,:id_produit, :quantite)");

    $nouveauProduitPanier->bindParam(":id_produit", $id_produit);
    $nouveauProduitPanier->bindParam(":id_panier", $id_panier);
    $nouveauProduitPanier->bindParam(":quantite", $quantite);

    $nouveauProduitPanier->execute();
    header("Location: /pages/panier.php");
}

function prixQtt($id_panier)
{
    global $bdd;

    $panier = $bdd->prepare("SELECT * FROM panier_produit WHERE id_panier = :id_panier");
    $panier->bindParam(":id_panier", $id_panier);
    $panier->execute();

    $prixFinal = 0;

    foreach ($panier as $pan) {
        $prix = prixProduit($pan["id_produit"]);
        $quantite = $pan["quantite"];
        $prixQtt = $prix * $quantite;

        $prixFinal += $prixQtt;
    }

    $tva = $prixFinal * (20 / 100);

    return $prixFinal += $tva;
}

function PanierValide($id_panier, $id_client)
{
    global $bdd;

    $insertHist = $bdd->prepare("INSERT INTO historique(id_panier, date_achat) VALUES (:id_panier, NOW())");
    $insertHist->bindParam(":id_panier", $id_panier);
    $insertHist->execute();

    createPanier($id_client);
}

function panierHistorique($id_client)
{
    global $bdd;

    $panierHist = $bdd->prepare("SELECT historique.id_panier FROM historique JOIN panier_produit ON historique.id_panier = panier_produit.id_panier JOIN panier ON panier_produit.id_panier = panier.id_panier WHERE panier.id_client = :id_client ORDER BY historique.id_panier DESC LIMIT 1;");
    $panierHist->bindParam(":id_client", $id_client);
    $panierHist->execute();
    $panier = $panierHist->fetchColumn();

    return $panier;
}
