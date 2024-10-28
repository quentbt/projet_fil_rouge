<?php
require 'vendor/autoload.php'; // Inclut Stripe PHP SDK

try {
    \Stripe\Stripe::setApiKey('sk_test_51Q51MLGqRZhDnoeOqGzwl1lZyKBAodebPTOn6LOqLj5TWlaxcYQvmJLuf0gY1xCfHWaplvQJ6hQaqLErmuPCcNdD00g0UL81K6'); // Clé API privée

    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => 'Produit exemple',
                ],
                'unit_amount' => 2000, // 20,00 €
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'https://localhost:3000/success.php',
        'cancel_url' => 'https://localhost:3000/cancel.php',
    ]);

    // Répondre en JSON valide
    header('Content-Type: application/json');
    echo json_encode(['id' => $checkout_session->id]);

} catch (Exception $e) {
    // Gérer l'erreur
    http_response_code(500); // Statut 500 pour indiquer une erreur serveur
    echo json_encode(['error' => $e->getMessage()]);
}



echo json_encode(['id' => $checkout_session->id]);
?>
