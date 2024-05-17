<?php

require_once "../connexion_bdd/connexion_bdd.php";
$bdd = db_connect();

function allCategorie()
{

    global $bdd;

    $categories = $bdd->query("SELECT * FROM categories");
    $categorie = $categories->fetchAll(PDO::FETCH_ASSOC);

    return $categorie;
}

function categorieAccueil()
{
    global $bdd;
    $selectCateg = $bdd->query("SELECT categorie, img_categ FROM categories ORDER BY ordre ASC");
    $categories = $selectCateg->fetchAll(PDO::FETCH_ASSOC);

    return $categories;
}



function modifOrdre($id_categ, $donnees)
{
    global $bdd;

    for ($i = 0; $i < count($id_categ); $i++) {
        $id_categorie = $id_categ[$i];
        $ordre = $donnees[$i];

        $nouveauOrdre = $bdd->prepare("UPDATE categories SET ordre = :ordre WHERE id_categorie = :id");
        $nouveauOrdre->bindParam(":ordre", $ordre);
        $nouveauOrdre->bindParam(":id", $id_categorie);
        $nouveauOrdre->execute();
    }

    header("Location: /pages/back_categorie.php");
}


function modifCateg($categorie, $emplacementImage, $nomImage, $nouveau_nom_categorie)
{

    global $bdd;
    move_uploaded_file($emplacementImage, "../images/" . $nomImage);
    if (empty($nouveau_nom_categorie)) {

        $nouveau_nom_categorie = $categorie;
    }

    $new_image_categ = $bdd->prepare("UPDATE categories SET img_categ = '/images/$nomImage', categorie = :new_categ WHERE categorie = :categ");
    $new_image_categ->bindParam(":categ", $categorie);
    $new_image_categ->bindParam(":new_categ", $nouveau_nom_categorie);
    $new_image_categ->execute();

    if ($new_image_categ->rowCount() > 0) {

        echo "La catégorie $categorie à bien été modifié";
    } else {

        echo "Il y a eu une erreur, auncune image n'as changé.";
    }

    header("Location: /pages/back_produits.php");
}
