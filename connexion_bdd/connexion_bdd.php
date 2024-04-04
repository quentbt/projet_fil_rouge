<?php

require_once "identifiant.php";

function db_connect()
{
    try {
        $bdd = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        $bdd = $e->getMessage();
    }

    return $bdd;
}

function db_disconnect($db)
{
    $bdd = null;
}
