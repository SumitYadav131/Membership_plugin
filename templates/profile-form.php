<?php
if (!defined('ABSPATH'))
    exit;

if (!is_user_logged_in()):
    ?>
    <p>You must be logged in to access your profile.</p>
    <a href="/login" class="button">Login</a>

<?php else:

    $user = wp_get_current_user();
    $membership_id = get_user_meta($user->ID, 'membership_level', true);
    $membership_status = get_user_meta($user->ID, 'membership_status', true);
    $membership_expiry = get_user_meta($user->ID, 'membership_expiry', true);

    $membership_name = $membership_id
        ? get_post_meta($membership_id, 'md_level_name', true)
        : 'No active membership';

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
                                <input type="text" name="street_address" value="<?php echo esc_attr($user->street_address); ?>"
                                    required>
                            </div>
                            <div class="field_wrapper">
                                <div class="city-field">
                                    <label>City</label><br>
                                    <input type="text" name="city" value="<?php echo esc_attr($user->city); ?>" required>
                                </div>

                                <div class="state-field">
                                    <label>State / Province:
                                    </label><br>
                                    <input type="text" name="state" value="<?php echo esc_attr($user->state); ?>" required>
                                </div>
                            </div>
                            <div class="field_wrapper">
                                <div class="pincode-field">
                                    <label>Postal Code / Pincode
                                    </label><br>
                                    <input type="number" name="pincode" value="<?php echo esc_attr($user->pincode); ?>"
                                        required>
                                </div>

                                <div class="country-field">
                                    <label>Country
                                    </label><br>
                                    <input type="text" name="pincode" value="<?php echo esc_attr($user->country); ?>" required>
                                </div>
                            </div>
                            <div class="field_wrapper">
                                <div class="password-field">
                                    <label> Password
                                    </label><br>
                                    <input type="password" name="pincode" value="<?php echo esc_attr($user->password); ?>"
                                        required>
                                </div>

                                <div class="cfm-password-field">
                                    <label>Confirm Password
                                    </label><br>
                                    <input type="password" name="pincode" value="<?php echo esc_attr($user->password); ?>"
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

                    <p><strong>Plan:</strong> <?php echo esc_html($membership_name); ?></p>
                    <p><strong>Status:</strong> <?php echo esc_html($membership_status); ?></p>
                    <p><strong>Expires On:</strong> <?php echo esc_html($expiry_text); ?></p>

                    <?php if ($membership_id): ?>
                        <a href="/membership-upgrade" class="button">Upgrade Membership</a>

                        <form method="post" class="md-cancel-form">
                            <?php wp_nonce_field('md_cancel_membership', 'md_cancel_nonce'); ?>
                            <button type="submit" name="md_cancel_membership" class="button md-cancel-btn">
                                Cancel Membership
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="/membership-levels" class="button">Choose a Membership</a>
                    <?php endif; ?>
                </div>
                <?php
            }
            ?>


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

?>