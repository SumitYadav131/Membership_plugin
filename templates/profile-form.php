<?php
if (!defined('ABSPATH'))
    exit;

if (!is_user_logged_in()):
    ?>
    <p>You must be logged in to access your profile.</p>
    <a href="/login" class="button">Login</a>

<?php else:

    $user = wp_get_current_user();
    $member_street = get_user_meta($user->ID, 'member_street', true);
    $member_city = get_user_meta($user->ID, 'member_city', true);
    $member_state = get_user_meta($user->ID, 'member_state', true);
	$member_pincode = get_user_meta($user->ID, 'member_pincode', true);
	$member_country = get_user_meta($user->ID, 'member_country', true);

    $membership_info = get_membership_info();

    if (isset($membership_info)) {
        $membership_id = $membership_info[0]->membership_id;
        $membership_name = get_the_title($membership_id);
        $membership_status = $membership_info[0]->status;
        $subscription_id = $membership_info[0]->subscription_id;
        $create_date = $membership_info[0]->created_at;
        $date = explode(' ', $create_date);
        $date_created = $date[0];
        $period_type = $membership_info[0]->period_type;
        $curr_date = date('Y-m-d');
        $expire_date = date('Y-m-d', strtotime($curr_date . '+30 days'));
    }


    $expiry_text = $membership_expiry
        ? date('F j, Y', strtotime($membership_expiry))
        : 'No expiration';

    $updated = isset($_GET['updated']);

    ?>

    <div class="md-profile-options">
        <div class="md-profile-settings">
            <ul class="p-0 list-unstyled md-profile-setting-listings">
                <li><a class="text-decoration-none" href="<?php get_template_directory_uri() ?>?setting=personalinfo">My
                        Profile</a></li>
                <hr>
                <li><a class="text-decoration-none"
                        href="<?php get_template_directory_uri() ?>?setting=membershipinfo">Membership Info</a></li>
                <hr>

                <li><a class="text-decoration-none" href="<?php get_template_directory_uri() ?>?setting=paymentinfo">Payment
                        Info</a></li>
                <hr>
                <li><a class="text-decoration-none" href="<?php get_template_directory_uri() ?>?setting=logout">Logout</a>
                </li>
            </ul>
        </div>
        <div class="md-profile-settings-menu">



            <?php

            if ($_GET['setting'] == '' || $_GET['setting'] === 'personalinfo') { ?>

                <div class="md-profile-personalinfo setting-menu-listing">

                    <?php if ($updated): ?>
                        <div class="md-success">Your profile was updated successfully.</div>
                    <?php endif; ?>

                    <h3>Personal Information</h3>

                    <form method="post" class="md-profile-form">

                        <div class="md-profile-field-cont">
                            <div class="profile-field">
                                <label>Full Name</label><br>
                                <input disabled type="text" name="display_name"
                                    value="<?php echo esc_attr($user->display_name); ?>" required>
                            </div>
                            <div class="profile-field">
                                <label>Email</label><br>
                                <input disabled type="email" name="user_email"
                                    value="<?php echo esc_attr($user->user_email); ?>" required>
                            </div>
                        </div>

                        <!-- Address field -->

                        <div class="md-address-field-cont">
                            <h3 class="mt-3">Address Details</h3>

                            <div class="address-field">
                                <label>Street Address</label><br>
                                <input type="text" name="street_address" value="<?php echo esc_attr($member_street); ?>"
                                    required>
                            </div>
                            <div class="field_wrapper">
                                <div class="city-field">
                                    <label>City</label><br>
                                    <input type="text" name="city" value="<?php echo esc_attr($member_city); ?>" required>
                                </div>

                                <div class="state-field">
                                    <label>State / Province:
                                    </label><br>
                                    <input type="text" name="state" value="<?php echo esc_attr($member_state); ?>" required>
                                </div>
                            </div>
                            <div class="field_wrapper">
                                <div class="pincode-field">
                                    <label>Postal Code / Pincode
                                    </label><br>
                                    <input type="number" name="pincode" value="<?php echo esc_attr($member_pincode); ?>" maxlength="6"  required>
                                </div>

                                <div class="country-field">
                                    <label>Country
                                    </label><br> 

                                    <select name="country" required>
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
                                </div>
                            </div>
                            <div class="field_wrapper">
                                <div class="password-field">
                                    <label> Password
                                    </label><br>
                                    <input type="password" name="password" value="<?php echo esc_attr($user->password); ?>"
                                        required>
                                </div>

                                <div class="cfm-password-field">
                                    <label>Confirm Password
                                    </label><br>
                                    <input type="password" name="password" value="<?php echo esc_attr($user->password); ?>"
                                        required>
                                </div>
                            </div>
                        </div>

                        <?php wp_nonce_field('md_profile_update_action', 'md_profile_nonce'); ?>
                        <button type="submit" name="md_update_profile" class="profile-save-btn button button-primary">Save
                            Profile</button>
                    </form>




                </div>

                <?php
            }
            ?>




            <?php
            if ($_GET['setting'] === 'membershipinfo') { ?>
                <div class="md-profile-membershipinfo setting-menu-listing">
                    <h3>Membership Information</h3>

                    <p><strong>Plan:</strong> <?php print_r($membership_name); ?></p>
                    <p><strong>Status:</strong> <?php echo esc_html($membership_status); ?></p>
                    <p><strong>Period Type:</strong> <?php echo esc_html($period_type); ?></p>
                    <p><strong>Expires On:</strong> <?php echo esc_html($expire_date); ?></p>

                    <?php if ($membership_id): ?>
                        <a href="/membership-upgrade" class="button">Upgrade Membership</a>
                        <button type="submit" data-sid="<?php echo $subscription_id ?>" id="membership_cancel"
                            name="md_cancel_membership" class="button md-cancel-btn">
                            Cancel Membership
                        </button>

                    <?php else: ?>
                        <a href="/membership-levels" class="button">Choose a Membership</a>
                    <?php endif; ?>
                </div>
                <?php
            }
            ?>


            <script>
                jQuery(document).ready(function ($) {

                    $('#membership_cancel').on('click', function (e) {
                        e.preventDefault();

                        var sid = $(this).data('sid');

                        $.ajax({
                            url: '<?php echo admin_url("admin-ajax.php"); ?>', // WP AJAX endpoint
                            type: 'POST',
                            data: {
                                action: 'membership_cancel_demand', // required
                                sus_id: sid
                            },
                            success: function (response) {
                                console.log('Server response:', response);
                              
                            },
                            error: function (xhr, status, error) {
                                console.error('AJAX Error:', error);
                            }
                        });
                    });

                });
            </script>

            <?php
            if ($_GET['setting'] === 'paymentinfo') { ?>
                <div class="md-profile-paymentinfo setting-menu-listing">
                    <h3>Payment History</h3>

                    <table class="md-payment-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $payments = md_get_user_payments($user->ID);
                            if ($payments):
                                foreach ($payments as $pay):
                                    echo '<tr>';
                                    echo '<td>' . esc_html(date('F j, Y', strtotime($pay->created_at))) . '</td>';
                                    echo '<td>' . esc_html(ucfirst($pay->method)) . '</td>';
                                    echo '<td>$' . esc_html($pay->amount) . '</td>';
                                    echo '<td>' . esc_html($pay->status) . '</td>';
                                    echo '</tr>';
                                endforeach;
                            else:
                                echo '<tr><td colspan="4">No payments found.</td></tr>';
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($_GET['setting']) && $_GET['setting'] === 'logout') {

                // Logout the user
                wp_logout();

                wp_redirect(home_url());

                exit;
            }
            ?>



        </div>
    </div>


<?php endif; ?>
<?php
function md_get_user_payments($user_id)
{
    global $wpdb;

    $table = $wpdb->prefix . 'md_subscriptions';

    return $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM $table WHERE user_id = %d ORDER BY created_at DESC", $user_id)
    );
}

// get membership function
function get_membership_info()
{
    global $wpdb;

    $table = $wpdb->prefix . "md_subscriptions";

    $user = get_current_user_id();

    $result = $wpdb->get_results("SELECT * FROM $table where user_id = $user");

    return $result;
}

?>