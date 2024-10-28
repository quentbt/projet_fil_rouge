<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Assurez-vous que ce chemin est correct
\Stripe\Stripe::setApiKey('sk_test_51Q51MLGqRZhDnoeOqGzwl1lZyKBAodebPTOn6LOqLj5TWlaxcYQvmJLuf0gY1xCfHWaplvQJ6hQaqLErmuPCcNdD00g0UL81K6'); // Remplacez par votre clé secrète Stripe

header('Content-Type: application/json');

// Récupération des items du panier envoyés depuis le frontend
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Exemple de lignes de produits, remplacez-les par les données réelles de votre panier
$line_items = [];
foreach ($data['items'] as $item) {
    $line_items[] = [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => 'Nom du produit', // Nom du produit
            ],
            'unit_amount' => 1000, // Prix en centimes (10.00 €)
        ],
        'quantity' => $item['quantity'],
    ];
}

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => 'http://localhost/projet_fil_rouge/pages/success.php',
        'cancel_url' => 'http://localhost/projet_fil_rouge/pages/cancel.php',
    ]);

    echo json_encode(['id' => $session->id]);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
