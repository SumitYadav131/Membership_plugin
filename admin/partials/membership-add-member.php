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

if (!current_user_can('manage_options')) {
  wp_die('Not allowed');
}

if (isset($_POST['createmember'])) {
  //Check nonce
  if (!isset($_POST['_wpnonce_create_md_admin_end']) || !wp_verify_nonce($_POST['_wpnonce_create_md_admin_end'], 'create_md_admin_end')) {
    //Nonce check failed.
    wp_die(__('Error! Nonce verification failed for user registration from admin end.', 'simple-membership'));
  }


  // Collect values
  $username = sanitize_text_field($_POST['username']);
  $email = sanitize_email($_POST['email']);
  $password = sanitize_text_field($_POST['password']);
  $first_name = sanitize_text_field($_POST['first_name']);
  $last_name = sanitize_text_field($_POST['last_name']);
  $gender = sanitize_text_field($_POST['gender']);
  $phone = sanitize_text_field($_POST['phone']);
  $street = sanitize_text_field($_POST['street']);
  $city = sanitize_text_field($_POST['city']);
  $state = sanitize_text_field($_POST['state']);
  $zipcode = sanitize_text_field($_POST['zipcode']);
  $country = sanitize_text_field($_POST['country']);
  $company = sanitize_text_field($_POST['company']);
  $notes = sanitize_textarea_field($_POST['admin_notes']);
  $status = sanitize_text_field($_POST['account_status']);
  $level = sanitize_text_field($_POST['membership_level']);
  $access = sanitize_text_field($_POST['access_starts']);
  $member_since = sanitize_text_field($_POST['member_since']);

  // 1. Create WordPress User
  $user_id = wp_insert_user([
    'user_login' => $username,
    'user_email' => $email,
    'user_pass' => $password,
    'first_name' => $first_name,
    'last_name' => $last_name,
    'role' => 'subscriber',
  ]);

  if (is_wp_error($user_id)) {
    wp_die('Error creating user: ' . $user_id->get_error_message());
  }

  // 2. Save custom profile fields in usermeta
  update_user_meta($user_id, 'gender', $gender);
  update_user_meta($user_id, 'phone', $phone);
  update_user_meta($user_id, 'street', $street);
  update_user_meta($user_id, 'city', $city);
  update_user_meta($user_id, 'state', $state);
  update_user_meta($user_id, 'zipcode', $zipcode);
  update_user_meta($user_id, 'country', $country);
  update_user_meta($user_id, 'company', $company);
  update_user_meta($user_id, 'admin_notes', $notes);
  update_user_meta($user_id, 'account_status', $status);
  update_user_meta($user_id, 'membership_level', $level);
  update_user_meta($user_id, 'access_starts', $access);
  update_user_meta($user_id, 'member_since', $member_since);

  // 3. (Optional) If your membership plugin has its own table, insert there too
  global $wpdb;
  $table = $wpdb->prefix . 'md_member'; // check your plugin tables
  if ($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table) {
    $wpdb->insert($table, [
      'user_id' => $user_id,
      'membership_level' => $level,
      'status' => $status,
      'access_start' => $access,
      'member_since' => $member_since,
    ]);
  }
  echo '<div class="updated notice"><p>Member  added successfully!</p></div>';


}
?>
<h3>Add Member</h3>
<form method="post" action="<?php echo admin_url('admin.php'); ?>?page=my_wp_membership">
  <input type="hidden" name="action" value="add_member">
  <?php wp_nonce_field('create_md_admin_end', '_wpnonce_create_md_admin_end') ?>

  <div class="form-wrapper">


    <div class="field-wrapper">
      <label for="username">Username</label>
      <input type="text" name="username" required>
    </div>

    <div class="field-wrapper">
      <label for="email">Email</label>
      <input type="email" name="email" required>
    </div>

    <div class="field-wrapper">
      <label for="password"> Password</label>
      <input type="password" name="password" required>
    </div>

    <div class="field-wrapper">
      <label for="password2">Retype Password</label>
      <input type="password" name="password2" required>
    </div>

    <div class="field-wrapper">
      <label for="account_status">Account Status</label>
      <select name="account_status">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>
    </div>

    <div class="field-wrapper">
      <label for="membership_level">Membership Level</label>
      <input type="text" name="membership_level">
    </div>

    <div class="field-wrapper">
      <label for="access_starts">Access Starts</label>
      <input type="date" name="access_starts">
    </div>

    <div class="field-wrapper">
      <label for="first_name">First Name</label>
      <input type="text" name="first_name">
    </div>

    <div class="field-wrapper">
      <label for="last_name">Last Name</label>
      <input type="text" name="last_name">
    </div>

    <div class="field-wrapper">
      <label for="gender">Gender</label>
      <select name="gender">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Others">Others</option>
      </select>
    </div>

    <div class="field-wrapper">
      <label for="phone">Phone</label>
      <input type="text" name="phone">
    </div>

    <div class="field-wrapper">
      <label for="street">Street</label>
      <input type="text" name="street">
    </div>

    <div class="field-wrapper">
      <label for="city">City</label>
      <input type="text" name="city"><br>
    </div>

    <div class="field-wrapper">
      <label for="state"> State</label>
      <input type="text" name="state">
    </div>

    <div class="field-wrapper">
      <label for="zipcode"> Zipcode</label>
      <input type="text" name="zipcode">
    </div>
    <div class="field-wrapper">
      <label for="country">Country</label>
      <select class="regular-text"  name="country">
        <option value="" selected="">(Please Select)</option>
        <option value="Afghanistan">Afghanistan</option>
        <option value="Albania">Albania</option>
        <option value="Algeria">Algeria</option>
        <option value="Andorra">Andorra</option>
        <option value="Angola">Angola</option>
        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
        <option value="Argentina">Argentina</option>
        <option value="Armenia">Armenia</option>
        <option value="Aruba">Aruba</option>
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
        <option value="Bonaire">Bonaire</option>
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
        <option value="Cayman Islands">Cayman Islands</option>
        <option value="Central African Republic">Central African Republic</option>
        <option value="Chad">Chad</option>
        <option value="Chile">Chile</option>
        <option value="China">China</option>
        <option value="Colombia">Colombia</option>
        <option value="Comoros">Comoros</option>
        <option value="Congo (Brazzaville)">Congo (Brazzaville)</option>
        <option value="Congo">Congo</option>
        <option value="Costa Rica">Costa Rica</option>
        <option value="Cote d'Ivoire">Cote d'Ivoire</option>
        <option value="Croatia">Croatia</option>
        <option value="Cuba">Cuba</option>
        <option value="Curacao">Curacao</option>
        <option value="Cyprus">Cyprus</option>
        <option value="Czech Republic">Czech Republic</option>
        <option value="Denmark">Denmark</option>
        <option value="Djibouti">Djibouti</option>
        <option value="Dominica">Dominica</option>
        <option value="Dominican Republic">Dominican Republic</option>
        <option value="East Timor (Timor Timur)">East Timor (Timor Timur)</option>
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
        <option value="French Polynesia">French Polynesia</option>
        <option value="Gabon">Gabon</option>
        <option value="Gambia, The">Gambia, The</option>
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
        <option value="Hong Kong">Hong Kong</option>
        <option value="Hungary">Hungary</option>
        <option value="Iceland">Iceland</option>
        <option value="India">India</option>
        <option value="Indonesia">Indonesia</option>
        <option value="Iran">Iran</option>
        <option value="Iraq">Iraq</option>
        <option value="Ireland">Ireland</option>
        <option value="Israel">Israel</option>
        <option value="Italy">Italy</option>
        <option value="Jamaica">Jamaica</option>
        <option value="Japan">Japan</option>
        <option value="Jordan">Jordan</option>
        <option value="Kazakhstan">Kazakhstan</option>
        <option value="Kenya">Kenya</option>
        <option value="Kiribati">Kiribati</option>
        <option value="Korea, North">Korea, North</option>
        <option value="Korea, South">Korea, South</option>
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
        <option value="Macedonia">Macedonia</option>
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
        <option value="Nepa">Nepa</option>
        <option value="Netherlands">Netherlands</option>
        <option value="New Zealand">New Zealand</option>
        <option value="Nicaragua">Nicaragua</option>
        <option value="Niger">Niger</option>
        <option value="Nigeria">Nigeria</option>
        <option value="Norway">Norway</option>
        <option value="Oman">Oman</option>
        <option value="Pakistan">Pakistan</option>
        <option value="Palau">Palau</option>
        <option value="Palestine">Palestine</option>
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
        <option value="Saint Vincent">Saint Vincent</option>
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
        <option value="Suriname">Suriname</option>
        <option value="Swaziland">Swaziland</option>
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
        <option value="United States of America">United States of America</option>
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
    </div>
    <div class="field-wrapper">
      <label for="company"> Company</label>
      <input type="text" name="company">
    </div>
    <div class="field-wrapper">
      <label for="member_since">Member Since</label>
      <input type="date" name="member_since">
    </div>
    <div class="field-wrapper">
      <label for="admin_notes">Admin Notes </label>
      <textarea rows="4" name="admin_notes"></textarea>
    </div>

    <div class="form-btn">
      <button class="button button-primary" type="submit" name="createmember">Add New Member</button>
    </div>

  </div>

</form>