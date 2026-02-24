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
  $gender = sanitize_text_field($_POST['member_gender']);
  $phone = sanitize_text_field($_POST['member_phone']);
  $street = sanitize_text_field($_POST['member_street']);
  $city = sanitize_text_field($_POST['member_city']);
  $state = sanitize_text_field($_POST['member_state']);
  $pincode = sanitize_text_field($_POST['member_pincode']);
  $country = sanitize_text_field($_POST['member_country']);
  $status = sanitize_text_field($_POST['account_status']);
  $level = sanitize_text_field($_POST['membership_level']);
  $access = sanitize_text_field($_POST['access_starts']);
  $member_since = sanitize_text_field($_POST['member_since']);



  $user_email = $email;
  $existing_user_id = email_exists($user_email);

  //1. Check if User already exists- Update member data
  if ($existing_user_id) {

    $user_id = wp_update_user([
      'ID'         => $existing_user_id,
      'user_pass'  => $password,
      'first_name' => $first_name,
      'last_name'  => $last_name,
    ]);

    //  if (is_wp_error($user_id)) {
    //   wp_die('Error creating user: ' . $user_id->get_error_message());
    // }

    // 2. Save custom profile fields in usermeta
    update_user_meta($user_id, 'member_gender', $gender);
    update_user_meta($user_id, 'member_phone', $phone);
    update_user_meta($user_id, 'member_street', $street);
    update_user_meta($user_id, 'member_city', $city);
    update_user_meta($user_id, 'member_state', $state);
    update_user_meta($user_id, 'member_pincode', $pincode);
    update_user_meta($user_id, 'member_country', $country);
    update_user_meta($user_id, 'account_status', $status);
    update_user_meta($user_id, 'membership_level', $level);
    update_user_meta($user_id, 'access_starts', $access);
    update_user_meta($user_id, 'member_since', $member_since);


    global $wpdb;

    // 3. Update Member data in "Md Member" table
    $table_member = $wpdb->prefix . 'md_member';

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_member'") === $table_member) {
        $wpdb->update($table_member, [
            'user_id'          => $user_id,
            'membership_level' => get_the_title($level),
            'status'           => $status,
            'access_start'     => $access,
            'member_since'     => $member_since,
            'gender'           => $gender,
            'phone'            => $phone,
            'street'           => $street,
            'city'             => $city,
            'state'            => $state,
            'zipcode'          => $pincode,
            'country'          => $country,
        ],
        [
           'user_id' => $user_id 
        ]
      );
    }

    // 4. Update Member data in "Md Subscription" table.
    $table_subscription = $wpdb->prefix . 'md_subscriptions';

    $period_type = get_post_meta($level, '_membership_type', true);
    if (!$period_type) {
          $period_type = 'one_time';
      }

    $price = get_post_meta($level, 'membership_price', true);

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_subscription'") === $table_subscription) {
        $wpdb->update($table_subscription, [
            'membership_id' => $level,
            'gateway'       => 'offline',
            'period_type'   => $period_type,
            'price'         => $price,
            'total'         => $price,
            'status'        => 'Completed'
        ],
        [
           'user_id' => $user_id 
        ]
      );
    }

  echo '<div class="updated notice"><p>Member Updated successfully!</p></div>';


  }else{

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
    update_user_meta($user_id, 'member_gender', $gender);
    update_user_meta($user_id, 'member_phone', $phone);
    update_user_meta($user_id, 'member_street', $street);
    update_user_meta($user_id, 'member_city', $city);
    update_user_meta($user_id, 'member_state', $state);
    update_user_meta($user_id, 'member_pincode', $pincode);
    update_user_meta($user_id, 'member_country', $country);
    update_user_meta($user_id, 'account_status', $status);
    update_user_meta($user_id, 'membership_level', $level);
    update_user_meta($user_id, 'access_starts', $access);
    update_user_meta($user_id, 'member_since', $member_since);

   
    global $wpdb;
 
    //3. Insert Member data into "md_member" table
    $table_member = $wpdb->prefix . 'md_member';

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_member'") === $table_member) {
        $wpdb->insert($table_member, [
            'user_id'          => $user_id,
            'membership_level' => get_the_title($level),
            'status'           => $status,
            'access_start'     => $access,
            'member_since'     => $member_since,
            'gender'           => $gender,
            'phone'            => $phone,
            'street'           => $street,
            'city'             => $city,
            'state'            => $state,
            'zipcode'          => $pincode,
            'country'          => $country,
        ]);
    }

    // Insert Member data into "md_subscriptions" table
    $table_subscription = $wpdb->prefix . 'md_subscriptions';

    $period_type = get_post_meta($level, '_membership_type', true);
    if (!$period_type) {
          $period_type = 'one_time';
      }

    $price = get_post_meta($level, 'membership_price', true);

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_subscription'") === $table_subscription) {
        $wpdb->insert($table_subscription, [
            'user_id'       => $user_id,
            'membership_id' => $level,
            'gateway'       => 'offline',
            'period_type'   => $period_type,
            'price'         => $price,
            'total'         => $price,
            'status'        => 'Completed'
        ]);
    }

    echo '<div class="updated notice"><p>Member added successfully!</p></div>';

  }

}

 

 // Get membership level posts
  $members =  get_posts([
    'post_type'      => 'my_membership_level',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC'
]);


?>


<form method="post" action="">
  <input type="hidden" name="action" value="add_member">
  <?php wp_nonce_field('create_md_admin_end', '_wpnonce_create_md_admin_end') ?>
  
  <div class="form-wrapper add_member_form">
    <h3 class="title">Add New Member</h3>

    <div class="field-wrapper">
      <label for="username">Username</label>
      <input type="text" name="username" required>
    </div>

    <div class="field-wrapper">
      <label for="email">Email</label>
      <input type="email" name="email" class="email" required>
    </div>

    <div class="field-wrapper">
      <label for="member_phone">Phone</label>
      <input type="text" name="member_phone">
    </div>

    <div class="field-wrapper">
      <label for="password"> Password</label>
      <input type="password" name="password" class="password" required>
    </div>

    <div class="field-wrapper" style="position: relative;">
      <label for="password2">Retype Password</label>
      <input type="password" name="password2" class="confirm_password" required>
      <span class="toggle-password" onclick="toggleBothPasswords(this)"><img width="15px" src="/wp-content/plugins/Membership/public/assests/icon/eye.svg" alt="show"></span>
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
      <select name="membership_level" id="membership_level">
        <option value="">Select Membership Level</option>
        <?php foreach($members as $member): ?>
           <?php 
            $post_id = $member->ID;

            // Get the membership type from post meta
            $membership_type = get_post_meta($post_id, '_membership_type', true);

            // Fallback if meta not set
            if (!$membership_type) {
                $membership_type = 'one_time';
            }
        ?>

        <option value="<?php echo esc_attr($post_id); ?>">
            <?php echo esc_html($member->post_title); ?>
            - <?php echo esc_html($membership_type); ?>
        </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field-wrapper">
      <label for="access_starts">Access Starts</label>
      <input type="date" name="access_starts">
    </div>

    <div class="field-wrapper">
      <label for="member_since">Member Since</label>
      <input type="date" name="member_since">
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
      <label for="member_gender">Gender</label>
      <select name="member_gender">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Others">Others</option>
      </select>
    </div>

    <div class="field-wrapper">
      <label for="member_street">Street</label>
      <input type="text" name="member_street">
    </div>

    <div class="field-wrapper">
      <label for="member_city">City</label>
      <input type="text" name="member_city">
    </div>

    <div class="field-wrapper">
      <label for="member_state"> State</label>
      <input type="text" name="member_state">
    </div>

    <div class="field-wrapper">
      <label for="member_pincode"> Pincode</label>
      <input type="text" name="member_pincode">
    </div>

    <div class="field-wrapper">
      <label for="member_country">country</label>
      <select class="regular-text"  name="member_country">
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
    </div>

    <div class="form-btn">
      <button class="button button-primary membership" type="submit" name="createmember">Add New Member</button>
    </div>

  </div>

</form>



<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('form');

    form.addEventListener('submit', function (e) {
        const password = document.querySelector('.password').value;
        const confirmPassword = document.querySelector('.confirm_password').value;
        const email = document.querySelector('.email').value;

        if (password !== confirmPassword) {
            e.preventDefault();
            alert("Password & Confirm Password do not match!");
            return;
        }
    });
});

// GLOBAL FUNCTION — REQUIRED FOR onclick=""
function toggleBothPasswords(icon) {
    var pass1 = document.querySelector('.password');
    var pass2 = document.querySelector('.confirm_password');

    if (pass1.type === "password") {
        // SHOW BOTH
        pass1.type = "text";
        pass2.type = "text";

        // show HIDE icon
        icon.innerHTML = `<img width="15px" src="/wp-content/plugins/Membership/public/assests/icon/eye-crossed.svg" alt="hide">`;
    } else {
        // HIDE BOTH
        pass1.type = "password";
        pass2.type = "password";

        // show SHOW icon
        icon.innerHTML = `<img width="15px" src="/wp-content/plugins/Membership/public/assests/icon/eye.svg" alt="show">`;
    }
}
</script>
