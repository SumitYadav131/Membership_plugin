<?php
// create-payment-intent.php
header('Content-Type: application/json');

// include Stripe lib (adjust path if different)



require_once '/home1/mydevits/public_html/alqimi/wp-content/plugins/Membership/lib/init.php';

// Set your secret key (server-side only)
\Stripe\Stripe::setApiKey('sk_test_51JeCtcSBo56wci5DRXTInJi6EjyQVvLrFiM1H8CpFAklVdKXEevdbItOnS3smrWZuhdm6PFknppO7J5qwnSVF3mW00ywvc7RmJ'); // <-- REPLACE


$input = json_decode(file_get_contents("php://input"), true);

try {
    // 1. Create Customer
    $customer = \Stripe\Customer::create([
        'email' => $input['member_email'],
    ]);

    // 2. Create SetupIntent
    $setupIntent = \Stripe\SetupIntent::create([
        'customer' => $customer->id,
        'payment_method_types' => ['card'],
    ]);

    echo json_encode([
        'clientSecret' => $setupIntent->client_secret,
        'customer_id' => $customer->id
    ]);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
exit;