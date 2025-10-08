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

