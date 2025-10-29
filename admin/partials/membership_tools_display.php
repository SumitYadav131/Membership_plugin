<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://mydevitsolutions.com
 * @since      1.0.0
 *
 * @package    Membership
 * @subpackage Membership/admin/partials
 */
?>
<?php
global $wpdb; ?>

  <div class="container">
    <h2>Pay $20 (Test)</h2>
    <div id="card-element"></div>
    <div id="card-errors" role="alert" class="error"></div>

    <button id="pay">Pay $20</button>
    <span id="spinner" class="spinner hidden">Processing…</span>
  </div>

  <script src="https://js.stripe.com/v3/"></script>
  <script>
    // Replace with your publishable key
    const stripe = Stripe('pk_test_51JeCtcSBo56wci5DPBeFwFEHjVpsqxCC0p9ldlFwozD2wm9wSRXu2tQY7CKuDrM3NFcVQ8vWK8JHv3NxTOTAKVbx00Eirc5WTE'); // <-- REPLACE

    // Create an instance of Elements
    const elements = stripe.elements();

    // Create card element with simple style
    const style = {
      base: {
        fontSize: '16px',
        color: '#32325d',
        '::placeholder': { color: '#a0aec0' }
      },
      invalid: { color: '#b00020' }
    };

    const card = elements.create('card', { style });
    card.mount('#card-element');

    // Display realtime errors
    const errorDiv = document.getElementById('card-errors');
    card.on('change', function(event) {
      errorDiv.textContent = event.error ? event.error.message : '';
    });

    const payBtn = document.getElementById('pay');
    const spinner = document.getElementById('spinner');

    payBtn.addEventListener('click', async () => {
      // disable button + show loader
      payBtn.disabled = true;
      spinner.classList.remove('hidden');
      errorDiv.textContent = '';

      // Create PaymentIntent on the server
      const createResp = await fetch('/wp-content/plugins/Membership/admin/partials/create_payment.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ amount: 2000, currency: 'usd' }) // amount in cents
      });

      const createData = await createResp.json();
      if (createData.error) {
        errorDiv.textContent = createData.error;
        payBtn.disabled = false;
        spinner.classList.add('hidden');
        return;
      }

      const clientSecret = createData.clientSecret;

      // Confirm the card payment
      const result = await stripe.confirmCardPayment(clientSecret, {
        payment_method: {
          card: card,
          billing_details: {
            // collect more details from user form if available
            name: 'Test User'
          }
        }
      });
     
      if (result.error) {
        // Show error to customer
        errorDiv.textContent = result.error.message;
        payBtn.disabled = false;
        spinner.classList.add('hidden');
      } else {
        if (result.paymentIntent && result.paymentIntent.status === 'succeeded') {
          // Payment succeeded — redirect or show success
          window.location.href = 'success.php?pid=' + encodeURIComponent(result.paymentIntent.id);
        } else {
          errorDiv.textContent = 'Payment processing: ' + result.paymentIntent.status;
          payBtn.disabled = false;
          spinner.classList.add('hidden');
        }
      }
    });
  </script>

<h1>Paypal Testing </h1>
<?php
// create-order.php
$clientId = 'AWKLVPdV6n0_GjnySM-CVlFwiA8wwrXfVz5Si_rMOKhw1cmM79UGQV4zJCXP8S0sey_O506atJ2sDJ9l';
$secret = 'EGTq9o7LyIBRlpCh85qDMWcRn1kkeKhW_IUplkXfnictbmWI-GWnY5LUzJd_JYI9GBlBQfBwCT_JJY63';

// Get access token first (same as above)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api-m.sandbox.paypal.com/v1/oauth2/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$clientId:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
$tokenResponse = curl_exec($ch);
curl_close($ch);
$accessToken = json_decode($tokenResponse, true)['access_token'];

// Create order
$orderData = [
    'intent' => 'CAPTURE',
    'purchase_units' => [[
        'amount' => [
            'currency_code' => 'USD',
            'value' => '20.00'
        ]
    ]],
    'application_context' => [
        'return_url' => 'http://alqimi.mydevitsolution.com/success.php',
        'cancel_url' => 'http://alqimi.mydevitsolution.com/cancel.php'
    ]
];

$ch = curl_init("https://api-m.sandbox.paypal.com/v2/checkout/orders");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $accessToken"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));

$response = curl_exec($ch);
curl_close($ch);

$order = json_decode($response, true);
print_r($order);
// Redirect user to PayPal approval URL
$approvalUrl = '';
foreach($order['links'] as $link){
    if($link['rel'] === 'approve'){
        $approvalUrl = $link['href'];
        break;
    }
}

if($approvalUrl){
    header("Location: $approvalUrl");
    exit;
} else {
    echo "Error creating PayPal order";
    print_r($order);
}
