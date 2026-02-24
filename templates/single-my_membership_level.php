<?php
get_header();

if( is_user_logged_in()){

		$user = wp_get_current_user();
	
		$name = $user->display_name;
	
		$email = $user->user_email;

		$street = get_user_meta($user->ID, 'member_street', true);

		$city = get_user_meta($user->ID, 'member_city', true);

		$state = get_user_meta($user->ID, 'member_state', true);

		$pincode = get_user_meta($user->ID, 'member_pincode', true);
		
		$member_country = get_user_meta($user->ID, 'member_country', true);

	}else{

		$name = '';

		$email = '';

		$street = get_user_meta($user->ID, '', true);
	}

if (have_posts()) :
	while (have_posts()) : the_post(); 
	
	?>

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
					<input type="text" name="member_name" id="member_name" value="<?php echo esc_attr($name); ?>" required>
				</p>

				<p class="input-box half">
					<label for="member_email">Email Address:</label><br>
					<input type="email" name="member_email" id="member_email" value="<?php echo esc_attr($email); ?>" required>
				</p>

				<h3>Address Details</h3>

				<p class="input-box full">
					<label for="member_street">Street Address:</label><br>
					<input type="text" name="member_street" id="member_street" value="<?php echo esc_attr($street); ?>" required>
				</p>

				<p class="input-box half">
					<label for="member_city">City:</label><br>
					<input type="text" name="member_city" id="member_city" value="<?php echo esc_attr($city); ?>" required>
				</p>

				<p class="input-box half">
					<label for="member_state">State / Province:</label><br>
					<input type="text" name="member_state" id="member_state" value="<?php echo esc_attr($state); ?>" required>
				</p>

				<p class="input-box half">
					<label for="member_pincode">Postal Code / Pincode:</label><br>
					<input type="number" name="member_pincode" id="member_pincode" maxlength="6" value="<?php echo esc_attr($pincode); ?>" required>
				</p>

				<p class="input-box half">
					<label for="member_country">Country:</label><br>
					<select name="member_country" id="member_country" required>
						<option value="">Select Country</option>

						<?php
							$countries = [
								"Afghanistan","Albania","Algeria","Andorra","Angola","Antigua and Barbuda","Argentina","Armenia",
								"Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus",
								"Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil",
								"Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde",
								"Central African Republic","Chad","Chile","China","Colombia","Comoros",
								"Congo, Democratic Republic of the","Congo, Republic of the","Costa Rica","Croatia","Cuba",
								"Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor",
								"Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Eswatini","Ethiopia",
								"Fiji","Finland","France","Gabon","Gambia","Georgia","Germany","Ghana","Greece","Grenada",
								"Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hungary","Iceland","India",
								"Indonesia","Iran","Iraq","Ireland","Israel","Italy","Ivory Coast","Jamaica","Japan","Jordan",
								"Kazakhstan","Kenya","Kiribati","Korea, North","Korea, South","Kosovo","Kuwait","Kyrgyzstan",
								"Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg",
								"Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania",
								"Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Morocco",
								"Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","New Zealand","Nicaragua",
								"Niger","Nigeria","North Macedonia","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea",
								"Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda",
								"Saint Kitts and Nevis","Saint Lucia","Saint Vincent and the Grenadines","Samoa","San Marino",
								"Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone",
								"Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","Spain","Sri Lanka",
								"Sudan","South Sudan","Suriname","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania",
								"Thailand","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu",
								"Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan",
								"Vanuatu","Vatican City","Venezuela","Vietnam","Yemen","Zambia","Zimbabwe"
							];

							foreach ($countries as $country) {
								$selected = ($member_country === $country) ? 'selected' : '';
								echo "<option value=\"$country\" $selected>$country</option>";
							}
							?> 
					</select>
				</p>
<?php if( !is_user_logged_in()){ ?>
				<p class="input-box half">
					<label for="member_password">Password:</label><br>
					<input type="password" name="member_password" id="member_password" required>
				</p>

				<p class="input-box half password" style="position: relative;" >
					<label for="member_confrim_password">Confirm Password:</label><br>
					<input type="password" name="member_confrim_password" id="member_confirm_password" required>
					<span class="toggle-password" onclick="toggleBothPasswords(this)"><img width="15px" src="/wp-content/plugins/Membership/public/assests/icon/eye.svg" alt="show"></span>
				</p>
<?php } ?>
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
				<input type="hidden" name="membership_id" id="membership_id" value="<?php echo get_the_ID(); ?>" />
				<div id="loader">
					<div class="spinner"></div>
				</div>
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
			document.addEventListener("DOMContentLoaded", function () {

				const stripeRadio = document.querySelector('input[name="payment_method"][value="stripe"]');
				const paypalRadio = document.querySelector('input[name="payment_method"][value="paypal"]');

				const stripeFields = document.getElementById('fields-stripe');
				const paypalFields = document.getElementById('fields-paypal');

				// ✅ Default Stripe Selected
				stripeRadio.checked = true;
				stripeFields.style.display = 'block';
				paypalFields.style.display = 'none';

				document.querySelectorAll('input[name="payment_method"]').forEach((radio) => {
					radio.addEventListener('change', function () {

						stripeFields.style.display = 'none';
						paypalFields.style.display = 'none';

						if (this.value === 'stripe') {
							stripeFields.style.display = 'block';
						}

						if (this.value === 'paypal') {
							paypalFields.style.display = 'block';
						}

						// ✅ Safe Stripe Clear
						if (typeof card !== "undefined") {
							card.clear();
						}
					});
				});

			});



			const membershipType = "<?php echo $membership_type; ?>";
			const stripePriceId = "<?php echo $stripe_price_id; ?>";

			const stripe = Stripe('pk_test_51JeCtcSBo56wci5DPBeFwFEHjVpsqxCC0p9ldlFwozD2wm9wSRXu2tQY7CKuDrM3NFcVQ8vWK8JHv3NxTOTAKVbx00Eirc5WTE');
			const elements = stripe.elements();
			const card = elements.create('card', {
				style: {
					base: {
						fontSize: '16px',
						color: '#32325d'
					}
				}
			});
			card.mount('#card-element');

			const form = document.getElementById('membership-form');
			const errorDiv = document.getElementById('card-errors');

			form.addEventListener('submit', async (e) => {
				e.preventDefault();
                jQuery('#loader').show();
				const name = document.getElementById('member_name').value;
				const email = document.getElementById('member_email').value;
				const password = document.getElementById('member_password')?.value || null;
				const membershipID = document.getElementById('membership_id').value;
				const member_street = document.getElementById('member_street').value;
				const member_city = document.getElementById('member_city').value;
				const member_state = document.getElementById('member_state').value;
				const member_pincode = document.getElementById('member_pincode').value;
				const member_country = document.getElementById('member_country').value;

				const confirmPassword = document.getElementById('member_confirm_password')?.value || null;

				// Password Match Validation
				if (password !== confirmPassword) {
					jQuery('#loader').hide();
					alert("Password & Confirm Password do not match!");
					return;
				}

				// Payment Feild
				const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
				
				if (!selectedMethod) {
					jQuery('#loader').hide();
					alert("Please select a payment method!");
					return;
				}

				if (selectedMethod.value === 'paypal') {
						jQuery('#loader').hide();
					alert("PayPal integration is currently not available. Please use Stripe to complete your payment.");
					return;
				}
				
				



				if (membershipType === "one_time") {
					// 1️⃣ Create PaymentIntent on server
					const response = await fetch('/wp-content/plugins/Membership/admin/partials/create_payment.php', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json'
						},
						body: JSON.stringify({
							amount: 2000,
							currency: 'usd',
							member_email: email
						})
					});
					const data = await response.json();
					if (data.error) {
						errorDiv.textContent = data.error;
						return;
					}

					// 2️⃣ Confirm card payment
					const result = await stripe.confirmCardPayment(data.clientSecret, {
						payment_method: {
							card: card,
							billing_details: {
								name,
								email
							}
						}
					});

					if (result.error) {
						   jQuery('#loader').hide();
						errorDiv.textContent = result.error.message;
						return;
					}

					// 3️⃣ Register user in WP
					const formData = new FormData(form);
					formData.append('action', 'register_after_payment');
					formData.append('plan_type', 'one_time');
					formData.append('payment_id', result.paymentIntent.id);

					const register = await fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
						method: 'POST',
						body: formData
					});
					const out = await register.json();
                     jQuery('#loader').hide();
					if (out.success) {
						window.location.href = '/thank-you/';
					} else {
						errorDiv.textContent = out.message;
					}
				}

				if (membershipType === "subscription") {
					// 1️⃣ Create SetupIntent on server
					const response = await fetch('/wp-content/plugins/Membership/admin/partials/create_subscription.php', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json'
						},
						body: JSON.stringify({
							member_email: email
						})
					});
					const data = await response.json();
					if (data.error) {
						errorDiv.textContent = data.error;
						return;
					}

					// 2️⃣ Confirm card setup
					const result = await stripe.confirmCardSetup(data.clientSecret, {
						payment_method: {
							card: card,
							billing_details: {
								name,
								email
							}
						}
					});

					if (result.error) {
						   jQuery('#loader').hide();
						errorDiv.textContent = result.error.message;
						return;
					}

					// 3️⃣ Register user and create subscription
					const formData = new FormData(form);
					formData.append('action', 'register_after_payment');
					formData.append('plan_type', 'subscription');
					formData.append('payment_method', result.setupIntent.payment_method);
					formData.append('price_id', stripePriceId);
					formData.append('customer_id', data.customer_id);
					formData.append('membershipid', membershipID);

					const register = await fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
						method: 'POST',
						body: formData
					});
					const out = await register.json();
					jQuery('#loader').hide();
					if (out.success) {
						window.location.href = '/thank-you/';
					} else {
						errorDiv.textContent = out.message;
					}
				}
			});



			function toggleBothPasswords(icon) {
				var pass1 = document.getElementById("member_password");
				var pass2 = document.getElementById("member_confirm_password");

				if (pass1.type === "password" && pass2.type === "password") {
					pass1.type = "text";
					pass2.type = "text";
					icon.innerHTML = `<img width="15px" src="/wp-content/plugins/Membership/public/assests/icon/eye.svg" alt="hide">`;
					
				} else {
					pass1.type = "password";
					pass2.type = "password";
					icon.innerHTML = `<img width="15px" src="/wp-content/plugins/Membership/public/assests/icon/eye-crossed.svg" alt="show">`;
				}
			}
		</script>


<?php endwhile;
endif;
get_footer();
?>