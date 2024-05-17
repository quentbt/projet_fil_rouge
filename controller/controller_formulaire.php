<?php
require_once 'controller_categorie.php';
require_once 'controller_produit.php';
require_once 'controller_panier.php';

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
        $nomImage = $_FILES["image"]["name"];
        $origineImage = $_FILES["image"]["tmp_name"];

        ajouterProduit($categ, $nom, $desc, $prix, $piece, $stock, $materiaux, $nomImage, $origineImage);
    }
}
