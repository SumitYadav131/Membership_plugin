<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
require_once '/home1/mydevits/public_html/alqimi/wp-content/plugins/Membership/lib/init.php';
\Stripe\Stripe::setApiKey('sk_test_51JeCtcSBo56wci5DRXTInJi6EjyQVvLrFiM1H8CpFAklVdKXEevdbItOnS3smrWZuhdm6PFknppO7J5qwnSVF3mW00ywvc7RmJ');
require_once('/home1/mydevits/public_html/alqimi//wp-load.php'); // Adjust path to your WordPress root

$input = json_decode(file_get_contents("php://input"), true);
$member_email = sanitize_email($input['member_email']);

try {
    // Get or create WP user
    $user = get_user_by('email', $member_email);
    $user_id = $user ? $user->ID : null;

    // Use existing function from MemberajaxHandler
    $customer_id = (new MemberajaxHandler())->get_or_create_customer($member_email, $user_id);

    // Create SetupIntent for that customer
    $setupIntent = \Stripe\SetupIntent::create([
        'customer' => $customer_id,
        'payment_method_types' => ['card'],
    ]);

    echo json_encode([
        'clientSecret' => $setupIntent->client_secret,
        'customer_id' => $customer_id
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
exit;
?>
