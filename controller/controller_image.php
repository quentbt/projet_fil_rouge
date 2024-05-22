<?php

require_once "../connexion_bdd/connexion_bdd.php";
require_once "../controller/controller_produit.php";

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

    $imagesProduit = $bdd->prepare("SELECT * FROM images WHERE id_produit = :id_produit ORDER BY id_image ASC");
    $imagesProduit->bindParam(":id_produit", $id_produit);
    $imagesProduit->execute();

    return $imagesProduit;
}

function ajouterImageProduit($images)
{
    global $bdd;
    $id_produit = maxIdProduit();

    for ($i = 0; $i < count($images["name"]); $i++) {

        $nom = $images["name"][$i];
        $origine = $images["tmp_name"][$i];

        $destination = "../images/" . $nom;
        move_uploaded_file($origine, $destination);
        var_dump($nom, $origine, $destination);

        $insert_image = $bdd->prepare("INSERT INTO images(nom_image, id_produit) VALUES (:nom_image, :id_produit)");
        $insert_image->bindParam(":nom_image", $nom);
        $insert_image->bindParam(":id_produit", $id_produit);
        $insert_image->execute();
    }
    // header("Location: /pages/back_produits.php");
}
