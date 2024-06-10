<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . "/connexion_bdd/connexion_bdd.php");
$bdd = db_connect();

// Récupère toutes les catégories
function allCategorie()
{

    global $bdd;

    $categories = $bdd->query("SELECT * FROM categories");
    $categorie = $categories->fetchAll(PDO::FETCH_ASSOC);

    return $categorie;
}

// Retourne les catégorie affiché sur la page d'accueil
function categorieAccueil()
{
    global $bdd;
    $selectCateg = $bdd->query("SELECT categorie, img_categ FROM categories WHERE categorie_accueil = 1 ORDER BY ordre ASC");
    $categories = $selectCateg->fetchAll(PDO::FETCH_ASSOC);

    return $categories;
}

// Change l'ordre d'affichage des catégories sur la page d'accueil
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

// Modifie une catégorie
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

// Fonction qui modifie la table pour mettre affiche_categorie sur 1
function affiche_categorie_accueil($id_categorie)
{
    global $bdd;

    $bdd->exec("UPDATE categories SET categorie_accueil = 0");

    foreach ($id_categorie as $id) {
        $categorie_accueil = $bdd->prepare("UPDATE categories SET categorie_accueil = 1 WHERE id_categorie = :id");
        $categorie_accueil->bindParam(":id", $id);
        $categorie_accueil->execute();
    }
    header("Location: /pages/accueil.php");
}

// Fonction qui supprime toutes les catégories séléctionnées
function deleteCategorie($id_categorie)
{
    global $bdd;

    foreach ($id_categorie as $id) {
        $deleteCateg = $bdd->prepare("DELETE FROM categories WHERE id_categorie = :id");
        $deleteCateg->bindParam(":id", $id);
        $deleteCateg->execute();
    }
    header("Location: /pages/admin/back_categories.php");
}
