<?php

require_once "../connexion_bdd/connexion_bdd.php";
$bdd = db_connect();

// Permet d'obtenir tous les produits
function allProduit()
{
    global $bdd;

    $produits = $bdd->query("SELECT * FROM produits ORDER BY id_produit");
    $resultat = $produits->fetchAll(PDO::FETCH_ASSOC);

    return $resultat;
}

// Permet d'obtenir tous les produits pour 1 catégorie
function produitCategorie($categorie)
{
    global $bdd;

    $produitCateg = $bdd->prepare("SELECT * FROM produits WHERE produits.categorie = (SELECT id_categorie FROM categories WHERE categorie = :categ)");
    $produitCateg->bindParam(":categ", $categorie);
    $produitCateg->execute();

    return $produitCateg;
}

// Permet d'obtenir toutes les infos d'un produit
function infoProduit($id_produit)
{
    global $bdd;

    $produit = $bdd->prepare("SELECT * FROM produits WHERE id_produit = :id");
    $produit->bindParam(":id", $id_produit);
    $produit->execute();

    return $produit;
}

function allMateriaux()
{
    global $bdd;

    $allMateriaux = $bdd->query("SELECT * FROM materiaux");
    $materiaux = $allMateriaux->fetchAll(PDO::FETCH_ASSOC);

    return $materiaux;
}


// Permet d'obtenir tous les matériaux d'un produit
function materiauxProduit($id_produit)
{
    global $bdd;

    $selectMateriauxProduit = $bdd->prepare("SELECT materiaux FROM materiaux WHERE id_materiaux IN (SELECT id_materiaux FROM prod_mat WHERE id_produit = :id_produit)");
    $selectMateriauxProduit->bindParam(":id_produit", $id_produit);
    $selectMateriauxProduit->execute();

    return $selectMateriauxProduit->fetchAll(PDO::FETCH_ASSOC);
}

// Permet d'obtenir 6 produits similaires (c'est à dire de la même catégorie) qui ont du stock
function produitSimilaire($id_produit)
{
    global $bdd;

    $produitSimilaire = $bdd->prepare("SELECT id_produit, nom, image_produit FROM produits WHERE categorie = (SELECT categorie FROM produits WHERE id_produit = :id_produit) AND id_produit != :id_produit AND stock > 0 ORDER BY RAND() LIMIT 6");
    $produitSimilaire->bindParam(":id_produit", $id_produit);
    $produitSimilaire->execute();

    return $produitSimilaire->fetchAll(PDO::FETCH_ASSOC);
}

// Permet de supprimer un produit
function deleteProduit($id_produit)
{
    global $bdd;

    foreach ($id_produit as $id) {

        $deleteProduit = $bdd->prepare("DELETE FROM produits WHERE id_produit = :id_produit");
        $deleteProduit->bindParam(":id_produit", $id);
        $deleteProduit->execute();

        $deleteMatProd = $bdd->prepare("DELETE FROM prod_mat WHERE id_produit = :id_produit");
        $deleteMatProd->bindParam(":id_produit", $id);
        $deleteMatProd->execute();
    }
    header("Location: /pages/back_produits.php");
}

// Récupère le stock d'un produit
function stockProduit($id_produit)
{
    global $bdd;

    $stockMax = $bdd->prepare("SELECT stock FROM produits WHERE id_produit = :id");
    $stockMax->bindParam(":id", $id_produit);
    $stockMax->execute();

    $stock = $stockMax->fetchColumn();

    return $stock;
}

// Répère le prix d'un produit
function prixProduit($id_produit)
{
    global $bdd;

    $prixProduit = $bdd->prepare("SELECT prix FROM produits WHERE id_produit = :id");
    $prixProduit->bindParam(":id", $id_produit);
    $prixProduit->execute();

    $prix = $prixProduit->fetchColumn();

    return $prix;
}

// Permet de choisir une quantité pour un produit (MAX : 10)
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

// Actualise les stocks après avoir passé une commande
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

// Récupère le max(id) de la table produits
function maxIdProduit()
{
    global $bdd;

    $maxId = $bdd->query("SELECT MAX(id_produit) FROM produits");
    $id = $maxId->fetchColumn();

    return $id;
}

// Ajouter un produit dans la table 
function ajouterProduit($id_categorie, $nom, $description, $prix, $piece, $stock, $materiaux, $nomImage, $origineImage)
{
    global $bdd;

    $id_produit = maxIdProduit();
    $id_produit++;

    $ordre = maxOrdreProduit();
    $ordre++;
    $isActive = 0;

    $verification = $bdd->prepare("SELECT * FROM produits WHERE nom = :nom");
    $verification->bindParam(":nom", $nom);
    $verification->execute();

    if ($verification->rowCount() == 0) {

        $destination = "../images/" . $nomImage;
        move_uploaded_file($origineImage, $destination);

        $name = "/images/" . $nomImage;

        $add = $bdd->prepare("INSERT INTO produits(id_produit, nom, description, prix, piece, stock, categorie, image_produit, ordre, isActive) VALUES (:id_prod, :nom, :desc, :prix, :piece, :stock, :categ, :img, :ordre, :isActive)");
        $add->bindParam(":id_prod", $id_produit);
        $add->bindParam(":nom", $nom);
        $add->bindParam(":desc", $description);
        $add->bindParam(":prix", $prix);
        $add->bindParam(":piece", $piece);
        $add->bindParam(":stock", $stock);
        $add->bindParam(":categ", $id_categorie);
        $add->bindParam(":img", $name);
        $add->bindParam(":ordre", $ordre);
        $add->bindParam(":isActive", $isActive);
        $add->execute();

        foreach ($materiaux as $mat) {

            $m = intval($mat);

            $prod_mat = $bdd->prepare("INSERT INTO prod_mat(id_produit, id_materiaux) VALUES (:id_prod, :id_mat)");
            $prod_mat->bindParam(":id_prod", $id_produit);
            $prod_mat->bindParam(":id_mat", $m);
            $prod_mat->execute();
        }
        header("Location: /pages/back_produits.php");
    } else {

        echo "Un produit possède déjà ce nom, veuillez changer";
    }
}

function produitActif($id_produit)
{
    global $bdd;

    $bdd->exec("UPDATE produits SET isActive = 0");

    foreach ($id_produit as $id) {
        $produitMisEnAvant = $bdd->prepare("UPDATE produits SET isActive = 1 WHERE id_produit = :id_produit");
        $produitMisEnAvant->bindParam(":id_produit", $id);
        $produitMisEnAvant->execute();
    }
    header("Location: /pages/accueil.php");
}

function produitCarrousel()
{
    global $bdd;

    $produitCarrousel = $bdd->query("SELECT * FROM produits WHERE isActive = 1");
    $prodCar = $produitCarrousel->fetchAll(PDO::FETCH_ASSOC);

    return $prodCar;
}

function maxOrdreProduit()
{
    global $bdd;

    $max_ordre = $bdd->query("SELECT MAX(ordre) FROM produits");
    $ordre = $max_ordre->fetchColumn();
    return $ordre;
}
