<?php
// create-payment-intent.php
header('Content-Type: application/json');

// include Stripe lib (adjust path if different)sgi



require_once '/home1/mydevits/public_html/alqimi/wp-content/plugins/Membership/lib/init.php';

// Set your secret key (server-side only)
\Stripe\Stripe::setApiKey(''); // <-- REPLACE

// Example: read amount, currency from POST (always validate/sanitize in real app)
$input = json_decode(file_get_contents('php://input'), true);

$amount = isset($input['amount']) ? intval($input['amount']) : 2000; // cents
$currency = isset($input['currency']) ? $input['currency'] : 'usd';

try {
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $amount,
        'currency' => $currency,
        // 'payment_method_types' => ['card'], // optional (default includes card)
        // optional metadata:
        'metadata' => [
            'integration_check' => 'accept_a_payment',
            // add your order id, user id etc
        ],
    ]);

    echo json_encode([
        'clientSecret' => $paymentIntent->client_secret,
        'paymentIntentId' => $paymentIntent->id
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
