<?php
require_once 'controller_categorie.php';
require_once 'controller_produit.php';
require_once 'controller_panier.php';
require_once 'controller_image.php';

// Tous les formulaires arrivent sur cette page, des méthodes sont exécutés en fonction des boutons envoyés.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["ordreCateg"])) {

        $id_categories = $_POST["id_categorie"];
        $ordres = $_POST["ordre"];
        modifOrdre($id_categories, $ordres);
    } elseif (isset($_POST["modif_categ"])) {

        $cat = $_POST["categorie"];
        $tmpName = $_FILES["image"]["tmp_name"];
        $name = $_FILES["image"]["name"];
        $nouveau_nom = $_POST["new_name"];
        modifCateg($cat, $tmpName, $name, $nouveau_nom);
    } elseif (isset($_POST["panier"])) {

        $id_client = $_POST["id_client"];
        $id_produit = $_POST["id_produit"];
        $quantite = $_POST["quantite"];

        insertPanier($id_produit, $quantite, $id_client);
    } elseif (isset($_POST["produits_acheter"])) {

        $id_panier = $_POST["id_panier"];
        $id_client = $_POST["id_client"];
        $id_produit = $_POST["id_produit"];
        $quantite = $_POST["quantite"];

        nouveauStock($quantite, $id_produit);
        PanierValide($id_panier, $id_client);
    } elseif (isset($_POST["bouton_supprimer_produit"])) {

        $id_produit = $_POST["id_produit"];
        deleteProduit($id_produit);
    } elseif (isset($_POST["ajouter_produit"])) {

        $nom = $_POST["nom"];
        $desc = $_POST["desc"];
        $prix = $_POST["prix"];
        $stock = $_POST["stock"];
        $categ = $_POST["categ"];
        $piece = $_POST["piece"];
        $materiaux = $_POST["materiaux"];

        //image reference produit
        $nom_image_ref = $_FILES["image"]["name"];
        $origine_image_ref = $_FILES["image"]["tmp_name"];

        //toutes images produit
        $images = $_FILES["image_produit"];

        ajouterProduit($categ, $nom, $desc, $prix, $piece, $stock, $materiaux, $nom_image_ref, $origine_image_ref);
        ajouterImageProduit($images);
    } elseif (isset($_POST["id_produit"]) && isset($_POST["id_panier"])) {

        $id_produit = $_POST["id_produit"];
        $id_panier = $_POST["id_panier"];

        deleteProduitPanier($id_produit, $id_panier);
    } elseif (isset($_POST["produit_carrousel_accueil"])) {

        $id_produit = $_POST["id_produit"];
        produitActif($id_produit);
    }
}
