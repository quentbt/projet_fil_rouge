<?php

$root = $_SERVER["DOCUMENT_ROOT"];
require_once($root . "/connexion_bdd/connexion_bdd.php");
require_once($root . "/controller/controller_panier.php");
$bdd = db_connect();

// Récupère tous les utilisateurs
function allUser()
{
    global $bdd;

    $allUser = $bdd->query("SELECT * FROM clients");
    $resultat = $allUser->fetchAll(PDO::FETCH_ASSOC);

    return $resultat;
}

// Supprimer un utilisateur
function deleteUser($id_client)
{
    global $bdd;

    foreach ($id_client as $id) {

        $deleteUser = $bdd->prepare("DELETE FROM clients WHERE id_client = :id_client");
        $deleteUser->bindParam(":id_client", $id);
        $deleteUser->execute();
    }

    header("Location: /pages/back_client.php");
}

// Récupère toutes les commandes d'un utilisateur
function commandeUser($id_client)
{
    global $bdd;

    $requete = $bdd->prepare("SELECT p.id_panier, COUNT(pp.id_produit) as nbr_produit, h.date_achat as date_achat, cout_total FROM panier p JOIN panier_produit pp ON p.id_panier = pp.id_panier JOIN historique h ON p.id_panier = h.id_panier WHERE p.id_client = :id_client GROUP BY p.id_panier, date_achat ORDER BY YEAR(date_achat), id_panier;");
    $requete->bindParam(":id_client", $id_client);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_BOTH);

    return $resultat;
}

// Retourne l'adresse de livraison du user
function adresseLivraison($id_client)
{
    global $bdd;

    $adresse = $bdd->prepare("SELECT nom, prenom, adresse1, adresse2, ville, code_postal, adresse_fact, pays, telephone FROM clients WHERE id_client = :id_client");
    $adresse->bindParam(":id_client", $id_client);
    $adresse->execute();

    $resultat = $adresse->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

// Retourne l'adresse de facturation du user (Ajouter adresse_fact dans la bdd).
function adresseFacturation($id_client)
{
    global $bdd;

    $adresse = $bdd->prepare("SELECT nom_fact, prenom_fact, adresse_fact, ville_fact, code_post_fact, pays_fact, telephone_fact FROM clients WHERE id_client = :id_client");
    $adresse->bindParam(":id_client", $id_client);
    $adresse->execute();

    $resultat = $adresse->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

// Retourne toutes les informations d'un utilisateur
function infoUser($id_client)
{
    global $bdd;

    $infoUser = $bdd->prepare("SELECT * FROM clients WHERE id_client = :id_client");
    $infoUser->bindParam(":id_client", $id_client);
    $infoUser->execute();

    $user = $infoUser->fetchAll(PDO::FETCH_ASSOC);
    return $user;
}

function maxIdClient()
{
    global $bdd;
    $id_client = $bdd->query("SELECT MAX(id_client) AS id_client FROM clients");
    $id = $id_client->fetchColumn();

    return $id;
}

function verifMail($email)
{
    global $bdd;

    $requete = $bdd->prepare("SELECT COUNT(*) FROM clients WHERE email = :email");
    $requete->bindParam(':email', $email);
    $requete->execute();

    $emailCount = $requete->fetchColumn();

    return $emailCount;
}


function inscription($nom, $prenom, $adresse1, $adresse2, $ville, $cp, $tel, $email, $mdp, $mdp_valide)
{
    global $bdd;

    if ($mdp == $mdp_valide) {
        $hash_mdp = password_hash($mdp, PASSWORD_DEFAULT);

        if (empty($adresse2) || $adresse2 == NULL) {
            $adresse2 = "";
        }

        if (verifMail($email) > 0) {

            echo "Cette email est déjà utilisé";
            break;
        }

        $id_client = maxIdClient() + 1;

        $inscript = $bdd->prepare("INSERT INTO clients(id_client, nom, prenom, adresse1, adresse2, ville, code_postal, email, telephone, mdp) VALUES (:id_client, :nom, :prenom, :adresse1, :adresse2, :ville, :cp, :email, :tel, :mdp)");
        $inscript->bindParam(":id_client", $id_client);
        $inscript->bindParam(":nom", $nom);
        $inscript->bindParam(":prenom", $prenom);
        $inscript->bindParam(":adresse1", $adresse1);
        $inscript->bindParam(":adresse2", $adresse2);
        $inscript->bindParam(":ville", $ville);
        $inscript->bindParam(":cp", $cp);
        $inscript->bindParam(":email", $email);
        $inscript->bindParam(":tel", $tel);
        $inscript->bindParam(":mdp", $hash_mdp);
        $inscript->execute();
        $ins = $inscript->fetchAll(PDO::FETCH_ASSOC);

        header("Location: /pages/connexion.php");
        return $ins;
    } else {
        echo "les mots de passe ne correspondent pas";
        break;
    }
}

function connexion($email, $mdp)
{
    global $bdd;

    $client = $bdd->prepare("SELECT id_client, mdp FROM clients WHERE email = :email");
    $client->bindParam(':email', $email);
    $client->execute();

    $result = $client->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        if (password_verify($mdp, $result['mdp'])) {
            session_start();

            $_SESSION['id_client'] = $result['id_client'];
            $_SESSION['email'] = $email;

            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

db_disconnect($bdd);
