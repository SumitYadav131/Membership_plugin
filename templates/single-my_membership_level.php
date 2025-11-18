<?php
get_header();

if (have_posts()) :
	while (have_posts()) : the_post(); ?>

<script src="https://js.stripe.com/v3/"></script>

<div class="membership-level-detail">
	<h1 class="mem-title"><?php the_title(); ?></h1>

	<div class="membership-content">
		<?php the_content(); ?>
	</div>

	<hr>

	<h2 class="mem-title">Membership Signup Form</h2>

	<form id="membership-form">
		<p class="input-box half">
			<label for="member_name">Your Name:</label><br>
			<input type="text" name="member_name" id="member_name" required>
		</p>

		<p class="input-box half">
			<label for="member_email">Email Address:</label><br>
			<input type="email" name="member_email" id="member_email" required>
		</p>

		<h3>Address Details</h3>

		<p class="input-box full">
			<label for="member_street">Street Address:</label><br>
			<input type="text" name="member_street" id="member_street" required>
		</p>

		<p class="input-box half">
			<label for="member_city">City:</label><br>
			<input type="text" name="member_city" id="member_city" required>
		</p>

		<p class="input-box half">
			<label for="member_state">State / Province:</label><br>
			<input type="text" name="member_state" id="member_state" required>
		</p>

		<p class="input-box half">
			<label for="member_pincode">Postal Code / Pincode:</label><br>
			<input type="text" name="member_pincode" id="member_pincode" required>
		</p>

		<p class="input-box half">
			<label for="member_country">Country:</label><br>
			<input type="text" name="member_country" id="member_country" required>
		</p>

		<p class="input-box half">
			<label for="member_password">Password:</label><br>
			<input type="password" name="member_password" id="member_password" required>
		</p>

		<p class="input-box half">
			<label for="member_confrim_password">Confirm Password:</label><br>
			<input type="password" name="member_confrim_password" id="member_confrim_password" required>
		</p>

		<!-- <p class="input-box full">
			<span>Payment Details:</span>
			<div id="card-element" style="border:1px solid #ccc; padding:10px; border-radius:4px;"></div>
			<div id="card-errors" style="color:red; margin-top:10px;"></div>
		</p> -->

		<fieldset>
			<legend>Pay With</legend>

			<div>
				<label>
					<input type="radio" name="payment_method" value="paypal" /> PayPal
				</label>

				<label>
					<input type="radio" name="payment_method" value="stripe" /> Stripe
				</label>
			</div>
			
			<!-- PayPal -->
			<div id="fields-paypal" class="method-fields" aria-hidden="true">
				<p class="note">You will be redirected to PayPal to complete the payment.</p>
			</div>

			<!-- stripe -->
			<div id="fields-stripe" class="method-fields" aria-hidden="true">
				<div id="card-element" style="border:1px solid #ccc; padding:10px; border-radius:4px;"></div>
				<div id="card-errors" style="color:red; margin-top:10px;"></div>
			</div>

		</fieldset>

		<button type="submit" id="submitBtn">Join & Pay Now</button>
		
	</form>

</div>
<?php
$membership_type = get_post_meta(get_the_ID(), '_membership_type', true);
$stripe_price_id = get_post_meta(get_the_ID(), '_stripe_price_id', true);

// Fallback to one-time if empty
if (!$membership_type) {
    $membership_type = 'one_time';
}
?>

<script>
const membershipType = "<?php echo $membership_type; ?>";
const stripePriceId = "<?php echo $stripe_price_id; ?>";
const stripe = Stripe('pk_test_51JeCtcSBo56wci5DPBeFwFEHjVpsqxCC0p9ldlFwozD2wm9wSRXu2tQY7CKuDrM3NFcVQ8vWK8JHv3NxTOTAKVbx00Eirc5WTE'); // Replace with your publishable key
const elements = stripe.elements();
const card = elements.create('card', {style: {base: {fontSize: '16px', color: '#32325d'}}});
card.mount('#card-element');

const form = document.getElementById('membership-form');
const errorDiv = document.getElementById('card-errors');

form.addEventListener('submit', async (e) => {
	e.preventDefault();

	const name = document.getElementById('member_name').value;
	const email = document.getElementById('member_email').value;

	// Create PaymentIntent on server
	if (membershipType === "one_time") {
	const response = await fetch('/wp-content/plugins/Membership/admin/partials/create_payment.php', {
		method: 'POST',
		headers: {'Content-Type': 'application/json'},
		body: JSON.stringify({ amount: 2000, currency: 'usd' }) // $20.00
	});
	const data = await response.json();

	if (data.error) {
		errorDiv.textContent = data.error;
		return;
	}

	const clientSecret = data.clientSecret;

	// Confirm payment with Stripe
	const result = await stripe.confirmCardPayment(clientSecret, {
		payment_method: {
			card: card,
			billing_details: { name: name, email: email }
		}
	});

	if (result.error) {
		errorDiv.textContent = result.error.message;
		// Payment successful — now create user via AJAX
		const formData = new FormData(form);
		formData.append('action', 'register_after_payment');
	

		const register = await fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
			method: 'POST',
			body: formData
		});
		const registerData = await register.json();

		if (registerData.success) {
			alert('Account created successfully!');
			window.location.href = '/thank-you/';
		} else {
			errorDiv.textContent = registerData.message || 'Error creating account.';
		}
	} else if (result.paymentIntent && result.paymentIntent.status === 'succeeded') {
		// Payment successful — now create user via AJAX
		const formData = new FormData(form);
		formData.append('action', 'register_after_payment');
		formData.append('payment_id', result.paymentIntent.id);

		const register = await fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
			method: 'POST',
			body: formData
		});
		const registerData = await register.json();

		if (registerData.success) {
			alert('Account created successfully!');
			window.location.href = '/thank-you/';
		} else {
			errorDiv.textContent = registerData.message || 'Error creating account.';
		}
	}
} 
if (membershipType === "subscription") {

    const response = await fetch('/wp-content/plugins/Membership/admin/partials/create_subscription.php', {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email })
    });

    const data = await response.json();

    const result = await stripe.confirmCardSetup(data.clientSecret, {
        payment_method: {
            card: card,
            billing_details: { name, email }
        }
    });

    if (result.error) {
        errorDiv.textContent = result.error.message;
        return;
    }

    // send payment method + price id to WP AJAX
    const formData = new FormData(form);
    formData.append("action", "register_after_payment");
    formData.append("payment_method", result.setupIntent.payment_method);
    formData.append("price_id", stripePriceId);
    formData.append("plan_type", "subscription");

    const register = await fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
        method: "POST",
        body: formData
    });

    const out = await register.json();
    if (out.success) {
        alert("Subscription started!");
        window.location.href = "/thank-you/";
    } else {
        errorDiv.textContent = out.message;
    }
}


});

</script>

<?php endwhile; endif;
get_footer();
?>
