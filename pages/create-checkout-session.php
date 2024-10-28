<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require '../vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51Q51MLGqRZhDnoeOqGzwl1lZyKBAodebPTOn6LOqLj5TWlaxcYQvmJLuf0gY1xCfHWaplvQJ6hQaqLErmuPCcNdD00g0UL81K6');

// Lire les données JSON envoyées depuis le frontend
$input = file_get_contents("php://input");
echo $data = json_decode($input, true); // Décoder le JSON en tableau associatif
var_dump($data);
// Vérifier que les données sont bien reçues
if (!$data || !isset($data['id_panier']) || !isset($data['id_client']) || !isset($data['produits'])) {
    json_encode(['error' => 'Données manquantes ou incorrectes']);
    exit();
}

$id_panier = $data['id_panier'];
$id_client = $data['id_client'];
$produits = $data['produits'];

$line_items = [];

// Vérifier que le tableau des produits n'est pas vide
if (empty($produits)) {
    echo json_encode(['error' => 'Le panier est vide. Aucun produit trouvé.']);
    exit();
}

// Créer les items pour Stripe Checkout
foreach ($produits as $produit) {
    if (!isset($produit['id_produit']) || !isset($produit['quantite'])) {
        echo json_encode(['error' => 'Produit ou quantité manquant dans les données']);
        exit();
    }

    // Créer chaque produit à envoyer à Stripe
    $line_items[] = [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => 'Nom du produit ID ' . $produit['id_produit'], // Mettre le vrai nom du produit ici
            ],
            'unit_amount' => 2000,  // Montant en centimes (20,00 EUR), peut-être récupéré en fonction de l'ID produit
        ],
        'quantity' => $produit['quantite'],
    ];
}

try {
    // Créer la session de paiement Stripe
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => 'http://localhost:3000/success.php',
        'cancel_url' => 'http://localhost:3000/cancel.php',
    ]);

    echo json_encode(['id' => $checkout_session->id]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
