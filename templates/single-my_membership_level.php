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
					<input type="number" name="member_pincode" id="member_pincode" maxlength="6" required>
				</p>

				<p class="input-box half">
					<label for="member_country">Country:</label><br>
					<select name="member_country" id="member_country" required>
						<option value="">Select Country</option>

						<option value="Afghanistan">Afghanistan</option>
						<option value="Albania">Albania</option>
						<option value="Algeria">Algeria</option>
						<option value="Andorra">Andorra</option>
						<option value="Angola">Angola</option>
						<option value="Antigua and Barbuda">Antigua and Barbuda</option>
						<option value="Argentina">Argentina</option>
						<option value="Armenia">Armenia</option>
						<option value="Australia">Australia</option>
						<option value="Austria">Austria</option>
						<option value="Azerbaijan">Azerbaijan</option>
						<option value="Bahamas">Bahamas</option>
						<option value="Bahrain">Bahrain</option>
						<option value="Bangladesh">Bangladesh</option>
						<option value="Barbados">Barbados</option>
						<option value="Belarus">Belarus</option>
						<option value="Belgium">Belgium</option>
						<option value="Belize">Belize</option>
						<option value="Benin">Benin</option>
						<option value="Bhutan">Bhutan</option>
						<option value="Bolivia">Bolivia</option>
						<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
						<option value="Botswana">Botswana</option>
						<option value="Brazil">Brazil</option>
						<option value="Brunei">Brunei</option>
						<option value="Bulgaria">Bulgaria</option>
						<option value="Burkina Faso">Burkina Faso</option>
						<option value="Burundi">Burundi</option>
						<option value="Cambodia">Cambodia</option>
						<option value="Cameroon">Cameroon</option>
						<option value="Canada">Canada</option>
						<option value="Cape Verde">Cape Verde</option>
						<option value="Central African Republic">Central African Republic</option>
						<option value="Chad">Chad</option>
						<option value="Chile">Chile</option>
						<option value="China">China</option>
						<option value="Colombia">Colombia</option>
						<option value="Comoros">Comoros</option>
						<option value="Congo, Democratic Republic of the">Congo, Democratic Republic of the</option>
						<option value="Congo, Republic of the">Congo, Republic of the</option>
						<option value="Costa Rica">Costa Rica</option>
						<option value="Croatia">Croatia</option>
						<option value="Cuba">Cuba</option>
						<option value="Cyprus">Cyprus</option>
						<option value="Czech Republic">Czech Republic</option>
						<option value="Denmark">Denmark</option>
						<option value="Djibouti">Djibouti</option>
						<option value="Dominica">Dominica</option>
						<option value="Dominican Republic">Dominican Republic</option>
						<option value="East Timor">East Timor</option>
						<option value="Ecuador">Ecuador</option>
						<option value="Egypt">Egypt</option>
						<option value="El Salvador">El Salvador</option>
						<option value="Equatorial Guinea">Equatorial Guinea</option>
						<option value="Eritrea">Eritrea</option>
						<option value="Estonia">Estonia</option>
						<option value="Eswatini">Eswatini</option>
						<option value="Ethiopia">Ethiopia</option>
						<option value="Fiji">Fiji</option>
						<option value="Finland">Finland</option>
						<option value="France">France</option>
						<option value="Gabon">Gabon</option>
						<option value="Gambia">Gambia</option>
						<option value="Georgia">Georgia</option>
						<option value="Germany">Germany</option>
						<option value="Ghana">Ghana</option>
						<option value="Greece">Greece</option>
						<option value="Grenada">Grenada</option>
						<option value="Guatemala">Guatemala</option>
						<option value="Guinea">Guinea</option>
						<option value="Guinea-Bissau">Guinea-Bissau</option>
						<option value="Guyana">Guyana</option>
						<option value="Haiti">Haiti</option>
						<option value="Honduras">Honduras</option>
						<option value="Hungary">Hungary</option>
						<option value="Iceland">Iceland</option>
						<option value="India">India</option>
						<option value="Indonesia">Indonesia</option>
						<option value="Iran">Iran</option>
						<option value="Iraq">Iraq</option>
						<option value="Ireland">Ireland</option>
						<option value="Israel">Israel</option>
						<option value="Italy">Italy</option>
						<option value="Ivory Coast">Ivory Coast</option>
						<option value="Jamaica">Jamaica</option>
						<option value="Japan">Japan</option>
						<option value="Jordan">Jordan</option>
						<option value="Kazakhstan">Kazakhstan</option>
						<option value="Kenya">Kenya</option>
						<option value="Kiribati">Kiribati</option>
						<option value="Korea, North">Korea, North</option>
						<option value="Korea, South">Korea, South</option>
						<option value="Kosovo">Kosovo</option>
						<option value="Kuwait">Kuwait</option>
						<option value="Kyrgyzstan">Kyrgyzstan</option>
						<option value="Laos">Laos</option>
						<option value="Latvia">Latvia</option>
						<option value="Lebanon">Lebanon</option>
						<option value="Lesotho">Lesotho</option>
						<option value="Liberia">Liberia</option>
						<option value="Libya">Libya</option>
						<option value="Liechtenstein">Liechtenstein</option>
						<option value="Lithuania">Lithuania</option>
						<option value="Luxembourg">Luxembourg</option>
						<option value="Madagascar">Madagascar</option>
						<option value="Malawi">Malawi</option>
						<option value="Malaysia">Malaysia</option>
						<option value="Maldives">Maldives</option>
						<option value="Mali">Mali</option>
						<option value="Malta">Malta</option>
						<option value="Marshall Islands">Marshall Islands</option>
						<option value="Mauritania">Mauritania</option>
						<option value="Mauritius">Mauritius</option>
						<option value="Mexico">Mexico</option>
						<option value="Micronesia">Micronesia</option>
						<option value="Moldova">Moldova</option>
						<option value="Monaco">Monaco</option>
						<option value="Mongolia">Mongolia</option>
						<option value="Montenegro">Montenegro</option>
						<option value="Morocco">Morocco</option>
						<option value="Mozambique">Mozambique</option>
						<option value="Myanmar">Myanmar</option>
						<option value="Namibia">Namibia</option>
						<option value="Nauru">Nauru</option>
						<option value="Nepal">Nepal</option>
						<option value="Netherlands">Netherlands</option>
						<option value="New Zealand">New Zealand</option>
						<option value="Nicaragua">Nicaragua</option>
						<option value="Niger">Niger</option>
						<option value="Nigeria">Nigeria</option>
						<option value="North Macedonia">North Macedonia</option>
						<option value="Norway">Norway</option>
						<option value="Oman">Oman</option>
						<option value="Pakistan">Pakistan</option>
						<option value="Palau">Palau</option>
						<option value="Panama">Panama</option>
						<option value="Papua New Guinea">Papua New Guinea</option>
						<option value="Paraguay">Paraguay</option>
						<option value="Peru">Peru</option>
						<option value="Philippines">Philippines</option>
						<option value="Poland">Poland</option>
						<option value="Portugal">Portugal</option>
						<option value="Qatar">Qatar</option>
						<option value="Romania">Romania</option>
						<option value="Russia">Russia</option>
						<option value="Rwanda">Rwanda</option>
						<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
						<option value="Saint Lucia">Saint Lucia</option>
						<option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
						<option value="Samoa">Samoa</option>
						<option value="San Marino">San Marino</option>
						<option value="Sao Tome and Principe">Sao Tome and Principe</option>
						<option value="Saudi Arabia">Saudi Arabia</option>
						<option value="Senegal">Senegal</option>
						<option value="Serbia">Serbia</option>
						<option value="Seychelles">Seychelles</option>
						<option value="Sierra Leone">Sierra Leone</option>
						<option value="Singapore">Singapore</option>
						<option value="Slovakia">Slovakia</option>
						<option value="Slovenia">Slovenia</option>
						<option value="Solomon Islands">Solomon Islands</option>
						<option value="Somalia">Somalia</option>
						<option value="South Africa">South Africa</option>
						<option value="Spain">Spain</option>
						<option value="Sri Lanka">Sri Lanka</option>
						<option value="Sudan">Sudan</option>
						<option value="South Sudan">South Sudan</option>
						<option value="Suriname">Suriname</option>
						<option value="Sweden">Sweden</option>
						<option value="Switzerland">Switzerland</option>
						<option value="Syria">Syria</option>
						<option value="Taiwan">Taiwan</option>
						<option value="Tajikistan">Tajikistan</option>
						<option value="Tanzania">Tanzania</option>
						<option value="Thailand">Thailand</option>
						<option value="Togo">Togo</option>
						<option value="Tonga">Tonga</option>
						<option value="Trinidad and Tobago">Trinidad and Tobago</option>
						<option value="Tunisia">Tunisia</option>
						<option value="Turkey">Turkey</option>
						<option value="Turkmenistan">Turkmenistan</option>
						<option value="Tuvalu">Tuvalu</option>
						<option value="Uganda">Uganda</option>
						<option value="Ukraine">Ukraine</option>
						<option value="United Arab Emirates">United Arab Emirates</option>
						<option value="United Kingdom">United Kingdom</option>
						<option value="United States">United States</option>
						<option value="Uruguay">Uruguay</option>
						<option value="Uzbekistan">Uzbekistan</option>
						<option value="Vanuatu">Vanuatu</option>
						<option value="Vatican City">Vatican City</option>
						<option value="Venezuela">Venezuela</option>
						<option value="Vietnam">Vietnam</option>
						<option value="Yemen">Yemen</option>
						<option value="Zambia">Zambia</option>
						<option value="Zimbabwe">Zimbabwe</option>
					</select>
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
				const password = document.getElementById('member_password').value;
				const membershipID = document.getElementById('membership_id').value;
				const member_street = document.getElementById('member_street').value;
				const member_city = document.getElementById('member_city').value;
				const member_state = document.getElementById('member_state').value;
				const member_pincode = document.getElementById('member_pincode').value;
				const member_country = document.getElementById('member_country').value;





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
		</script>


<?php endwhile;
endif;
get_footer();
?>