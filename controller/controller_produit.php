<?php

require_once "../connexion_bdd/connexion_bdd.php";
$bdd = db_connect();

function allProduit()
{
    global $bdd;

    $produits = $bdd->query("SELECT * FROM produits");
    $resultat = $produits->fetchAll(PDO::FETCH_ASSOC);

    return $resultat;
}

function produitCategorie($categorie)
{
    global $bdd;

    $produitCateg = $bdd->prepare("SELECT * FROM produits WHERE produits.categorie = (SELECT id_categorie FROM categories WHERE categorie = :categ)");
    $produitCateg->bindParam(":categ", $categorie);
    $produitCateg->execute();

    return $produitCateg;
}

function infoProduit($id_produit)
{
    global $bdd;

    $produit = $bdd->prepare("SELECT * FROM produits WHERE id_produit = :id");
    $produit->bindParam(":id", $id_produit);
    $produit->execute();

    return $produit;
}

function materiauxProduit($id_produit)
{
    global $bdd;

    $selectMateriauxProduit = $bdd->prepare("SELECT materiaux FROM materiaux WHERE id_materiaux IN (SELECT id_materiaux FROM prod_mat WHERE id_produit = :id_produit)");
    $selectMateriauxProduit->bindParam(":id_produit", $id_produit);
    $selectMateriauxProduit->execute();

    return $selectMateriauxProduit->fetchAll(PDO::FETCH_ASSOC);
}

function produitSimilaire($id_produit)
{
    global $bdd;

    $produitSimilaire = $bdd->prepare("SELECT id_produit, nom FROM produits WHERE categorie = (SELECT categorie FROM produits WHERE id_produit = :id_produit) AND id_produit != :id_produit AND stock > 0 ORDER BY RAND() LIMIT 6");
    $produitSimilaire->bindParam(":id_produit", $id_produit);
    $produitSimilaire->execute();

    return $produitSimilaire->fetchAll(PDO::FETCH_ASSOC);
}

function deleteProduit($id_produit)
{
    global $bdd;
}

function stockProduit($id_produit)
{
    global $bdd;

    $stockMax = $bdd->prepare("SELECT stock FROM produits WHERE id_produit = :id");
    $stockMax->bindParam(":id", $id_produit);
    $stockMax->execute();

    $stock = $stockMax->fetchColumn();

    return $stock;
}

function prixProduit($id_produit)
{
    global $bdd;

    $prixProduit = $bdd->prepare("SELECT prix FROM produits WHERE id_produit = :id");
    $prixProduit->bindParam(":id", $id_produit);
    $prixProduit->execute();

    $prix = $prixProduit->fetchColumn();

    return $prix;
}


function quantite($id_produit)
{
    $stock = stockProduit($id_produit);
    $quantite = array();

    for ($i = 1; $i <= $stock; $i++) {
        $quantite[] = $i;
        if (sizeof($quantite) == 10) {
            break;
        }
    }
    return $quantite;
}

function nouveauStock($quantite, $id_produit)
{
    global $bdd;

    for ($i = 0; $i < count($quantite); $i++) {

        $id = $id_produit[$i];
        $stock = stockProduit($id);
        $qtt = $quantite[$i];
        $newStock = $stock - $qtt;

        $updateStock = $bdd->prepare("UPDATE produits SET stock = :nouveauStock WHERE id_produit = :id_produit");
        $updateStock->bindParam(":nouveauStock", $newStock);
        $updateStock->bindParam(":id_produit", $id);
        $updateStock->execute();
    }
}
