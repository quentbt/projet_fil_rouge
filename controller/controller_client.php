<?php

require_once "../connexion_bdd/connexion_bdd.php";
require_once "../controller/controller_panier.php";
$bdd = db_connect();

function allUser()
{
    global $bdd;

    $allUser = $bdd->query("SELECT * FROM clients");
    $resultat = $allUser->fetchAll(PDO::FETCH_ASSOC);

    return $resultat;
}

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
