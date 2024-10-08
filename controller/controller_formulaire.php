<?php
require_once 'controller_categorie.php';
require_once 'controller_produit.php';
require_once 'controller_panier.php';
require_once 'controller_image.php';
require_once 'controller_client.php';

// Tous les formulaires arrivent sur cette page, des méthodes sont exécutés en fonction des boutons envoyés.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Tous les elseif() concernant les catégories

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
    } elseif (isset($_POST["categorie_affiche"])) {

        $id_categorie = $_POST["id_categorie"];
        affiche_categorie_accueil($id_categorie);
    } elseif (isset($_POST["bouton_supprimer_categorie"])) {

        $id_categorie = $_POST["id_categorie"];
        deleteCategorie($id_categorie);
    }
    // Tous les elseif() concernant les produits
    elseif (isset($_POST["produits_acheter"])) {

        $id_panier = $_POST["id_panier"];
        $id_client = $_POST["id_client"];
        $id_produit = $_POST["id_produit"];
        $quantite = $_POST["quantite_panier"];

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
    } elseif (isset($_POST["produit_highlander"])) {

        $id_produit = $_POST["id_produit"];
        hihglanderAcceuil($id_produit);
    } elseif (isset($_POST["modif_produit"])) {

        $id_produit = $_POST["id_produit"];
        $nom = $_POST["nom"];
        $desc = $_POST["desc"];
        $prix = $_POST["prix"];
        $stock = $_POST["stock"];
        $piece = $_POST["piece"];
        $categorie = $_POST["categorie"];

        if (isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"])) {

            $img_ref = $_FILES["image"]["name"];
            $origine_img_ref = $_FILES["image"]["tmp_name"];
        } else {

            $img_ref = imageRefProduit($id_produit);
            $origine_img_ref = "";
        }

        modifierProduit($id_produit, $nom, $desc, $prix, $stock, $piece, $categorie, $img_ref, $origine_img_ref);
    }
    // Tous les elseif() concernant les clients
    elseif (isset($_POST["bouton_supprimer_client"])) {

        $id_client = $_POST["id_client"];
        $id_panier = panierClient($id_client);

        if (isset($id_panier) && !empty($id_panier)) {
            deleteHistorique($id_panier);
            deletePanierProduit($id_panier);
            deletePanier($id_client);
        }
        deleteUser($id_client);
    } elseif (isset($_POST["inscription"])) {

        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $adresse1 = $_POST["adresse1"];
        $adresse2 = $_POST["adresse2"];
        $ville = $_POST["ville"];
        $cp = $_POST["cp"];
        $tel = $_POST["tel"];
        $email = $_POST["email"];
        $mdp = $_POST["mdp"];
        $mdp_valide = $_POST["mdp_valide"];

        inscription($nom, $prenom, $adresse1, $adresse2, $ville, $cp, $tel, $email, $mdp, $mdp_valide);
    } elseif (isset($_POST["connexion"])) {

        $email = $_POST["email"];
        $mdp = $_POST["mdp"];
        connexion($email, $mdp);
    }
    // Tous les elseif() concernant le panier 
    elseif (isset($_POST["panier"])) {

        $id_client = $_POST["id_client"];
        $id_produit = $_POST["id_produit"];
        $quantite = $_POST["quantite"];

        insertPanier($id_produit, $quantite, $id_client);
    } elseif (isset($_POST['quantity'])) {

        $id_produit = $_POST["id_produit"];
        $id_panier = $_POST["id_panier"];
        $quantite = $_POST["quantity"];

        updateQuantiteProduit($id_produit, $id_panier, $quantite);
    }
}
