<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . '/connexion_bdd/connexion_bdd.php');
require_once($root . '/controller/controller_produit.php');

$bdd = db_connect();

// Récupère l'id max dans la table panier
function maxPanierId($id_client)
{
    global $bdd;

    $panierClient = $bdd->prepare("SELECT MAX(id_panier) FROM panier WHERE id_client = :id_client");
    $panierClient->bindParam(":id_client", $id_client);
    $panierClient->execute();
    $id = $panierClient->fetchColumn();

    if (!isset($id)) {

        $id = 0;
    }

    return $id;
}

// Créer un nouveau panier
function createPanier($id_client)
{
    global $bdd;
    $id = maxPanierId($id_client);
    $id += 1;

    $creationPanierClient = $bdd->prepare("INSERT INTO panier VALUES (:id_panier, :id_client)");
    $creationPanierClient->bindParam(":id_panier", $id);
    $creationPanierClient->bindParam(":id_client", $id_client);
    $creationPanierClient->execute();
}

// Affiche le panier sur la page panier.php
function affichePanier($id_client)
{
    global $bdd;

    $id_panier = maxPanierId($id_client);
    $id = intval($id_panier);


    $produitPanier = $bdd->prepare("SELECT produits.*, panier_produit.* FROM produits LEFT JOIN panier_produit ON produits.id_produit = panier_produit.id_produit WHERE panier_produit.id_panier = :panier");
    $produitPanier->bindParam(":panier", $id);
    $produitPanier->execute();
    $panier = $produitPanier->fetchAll(PDO::FETCH_ASSOC);

    return $panier;
}

// Insère un nouveau produit dans le panier
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

// Obtenir le prix total dans le panier
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

function updateQuantiteProduit($id_produit, $id_panier, $quantite)
{
    global $bdd;

    $modifQtt = $bdd->prepare("UPDATE panier_produit SET quantite = :quantite WHERE id_panier = :id_panier AND id_produit = :id_produit");
    $modifQtt->bindParam(":quantite", $quantite);
    $modifQtt->bindParam(":id_panier", $id_panier);
    $modifQtt->bindParam(":id_produit", $id_produit);
    $modifQtt->execute();
}

// Permet de validé une commande, créer un nouveau panier qui permet de remettre la page panier.php blanche
function PanierValide($id_panier, $id_client)
{
    global $bdd;
    $cout_total = prixQtt($id_panier);

    $insertHist = $bdd->prepare("INSERT INTO historique(id_panier, date_achat, cout_total) VALUES (:id_panier, NOW(), :cout_total)");
    $insertHist->bindParam(":id_panier", $id_panier);
    $insertHist->bindParam(":cout_total", $cout_total);
    $insertHist->execute();

    createPanier($id_client);
    header("Location: /pages/accueil.php");
}

// Supprime un produit du panier.
function deleteProduitPanier($id_produit, $id_panier)
{

    global $bdd;

    $deleteproduit = $bdd->prepare("DELETE FROM panier_produit WHERE id_produit = :id_produit AND id_panier = :id_panier");
    $deleteproduit->bindParam(":id_produit", $id_produit);
    $deleteproduit->bindParam(":id_panier", $id_panier);
    $deleteproduit->execute();

    header("Location: /pages/panier.php");
}

// Récupère tous les paniers d'un client
function panierClient($id_clients)
{
    global $bdd;

    foreach ($id_clients as $id) {

        $panierClient = $bdd->prepare("SELECT id_panier FROM panier WHERE id_client = :id_client");
        $panierClient->bindParam(":id_client", $id);
        $panierClient->execute();

        $panier = $panierClient->fetchALL(PDO::FETCH_ASSOC);
    }

    return $panier;
}

// Supprimer tous les paniers d'un client
function deletePanier($id_client)
{
    global $bdd;

    foreach ($id_client as $id) {

        $deletePanier = $bdd->prepare("DELETE FROM panier WHERE id_client = :id_client");
        $deletePanier->bindParam(":id_client", $id);
        $deletePanier->execute();
    }
}

// Supprimer toutes les commandes d'un client
function deletePanierProduit($id_panier)
{
    global $bdd;

    foreach ($id_panier as $id_pan) {

        $id = $id_pan["id_panier"];

        $deletePanierProduit = $bdd->prepare("DELETE FROM panier_produit WHERE id_panier = :id_panier");
        $deletePanierProduit->bindParam(":id_panier", $id);
        $deletePanierProduit->execute();
    }
}

// Supprime les commandes passé par un client
function deleteHistorique($id_panier)
{
    global $bdd;

    foreach ($id_panier as $id_pan) {

        $id = $id_pan["id_panier"];

        $deleteHistorique = $bdd->prepare("DELETE FROM historique WHERE id_panier = :id_panier");
        $deleteHistorique->bindParam(":id_panier", $id);
        $deleteHistorique->execute();
    }
}

// Séléctionne les produits d'une commande
function produitCommande($id_panier)
{
    global $bdd;

    $produitCommande = $bdd->prepare("SELECT p.*, pp.quantite  FROM produits p JOIN panier_produit pp ON pp.id_produit = p.id_produit WHERE id_panier = :id_panier");
    $produitCommande->bindParam(":id_panier", $id_panier);
    $produitCommande->execute();

    $panier = $produitCommande->fetchAll(PDO::FETCH_ASSOC);
    return $panier;
}
