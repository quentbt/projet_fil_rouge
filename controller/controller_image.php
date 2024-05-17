<?php

require_once "../connexion_bdd/connexion_bdd.php";
$bdd = db_connect();

// Récupère toutes les images
function allImage()
{

    global $bdd;
    $images = $bdd->query("SELECT * FROM images");
    $images->fetchAll(PDO::FETCH_ASSOC);

    return $images;
}

// retourne l'image d'une catégorie
function imageCategorie($categorie)
{
    global $bdd;
    $imageCategorie = $bdd->prepare("SELECT img_categ FROM categories WHERE categorie = :categorie");
    $imageCategorie->bindParam(':categorie', $categorie);
    $imageCategorie->execute();

    return $imageCategorie->fetch(PDO::FETCH_ASSOC)["img_categ"];
}

// Retournes toutes les images d'un produit
function imageProduit($id_produit)
{
    global $bdd;

    $imagesProduit = $bdd->prepare("SELECT nom_image AS nom FROM images WHERE id_produit = :id_produit ORDER BY id_image ASC");
    $imagesProduit->bindParam(":id_produit", $id_produit);
    $imagesProduit->execute();

    return $imagesProduit->fetchAll(PDO::FETCH_ASSOC);
}
