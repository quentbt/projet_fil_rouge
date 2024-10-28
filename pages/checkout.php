<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement - Stripe</title>
    <script src="https://js.stripe.com/v3/"></script> <!-- Stripe.js -->
</head>
<body>

<h2>Panier</h2>
<p>Montant total : 360€</p> <!-- Remplacez par le montant réel de votre panier -->

<!-- Bouton de paiement Stripe -->
<button id="checkout-button">Procéder au paiement</button>

<script type="text/javascript">
    // Initialisation de Stripe avec votre clé publique
    const stripe = Stripe('pk_test_51Q51MLGqRZhDnoeODGFovBEMepiHc4qSUzBWoobMprsQsXRLiWXI68qQG0H9UANOCctD7uBnXNzPeuIh5c8XH6Sl00obZln9dC'); 

    document.getElementById('checkout-button').addEventListener('click', function () {
        // Envoi d'une requête pour créer une session de paiement
        fetch('/projet_fil_rouge/pages/checkout_session.php', { // Assurez-vous que le chemin est correct
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                items: [
                    { id: 'product_id', quantity: 1 } // Remplacez avec des informations de produit dynamiques
                ]
            })
        })
        .then(response => response.json())
        .then(session => {
            // Redirection vers Stripe Checkout avec l'ID de session
            return stripe.redirectToCheckout({ sessionId: session.id });
        })
        .then(result => {
            if (result.error) {
                alert(result.error.message);
            }
        })
        .catch(error => console.error('Erreur:', error));
    });
</script>

</body>
</html>
