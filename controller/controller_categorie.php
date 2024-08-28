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

// Retourne les produits trouvé après avoir appliqué les filtres
function filtre_produit($min_prix, $max_prix, $materiaux, $categorie)
{
    global $bdd;

    // Récupération de l'ID de la catégorie
    $categ = $bdd->prepare("SELECT id_categorie FROM categories WHERE categorie = :categ");
    $categ->bindParam(":categ", $categorie);
    $categ->execute();
    $cat = $categ->fetchColumn();

    if (empty($max_prix)) {
        $max_prix = PHP_INT_MAX;
    }

    if (empty($min_prix)) {
        $min_prix = 0;
    }

    if ($min_prix > $max_prix) {
        echo "Problème prix";
        return;
    }

    if (sizeof($materiaux) == 0) {

        $requete = $bdd->prepare("SELECT * FROM produits WHERE prix >= :prix_min AND prix <= :prix_max AND categorie = :id_categorie");
        $requete->bindParam(":prix_min", $min_prix);
        $requete->bindParam(":prix_max", $max_prix);
        $requete->bindParam("id_categorie", $cat);
        $requete->execute();

        $produit_trouve = $requete->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $whereClause = implode(',', array_map('intval', $materiaux));

        // Construire la requête SQL
        $sql = " SELECT p.* FROM produits p JOIN prod_mat pm ON p.id_produit = pm.id_produit WHERE p.categorie = $cat AND pm.id_materiaux IN ($whereClause) GROUP BY p.id_produit HAVING COUNT(DISTINCT pm.id_materiaux) = " . count($materiaux) . ";";

        $requete = $bdd->query($sql);
        $req = $requete->fetchAll(PDO::FETCH_ASSOC);
        $produit_trouve = [];

        foreach ($req as $r) {

            $prix = $r["prix"];
            if ($prix >= $min_prix && $prix <= $max_prix) {

                $produit_trouve[] = $r;
            }
        }
    }
    return $produit_trouve;
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

db_disconnect($bdd);
