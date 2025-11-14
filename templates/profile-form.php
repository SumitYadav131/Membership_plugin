<?php
if ( ! defined('ABSPATH') ) exit;

if ( ! is_user_logged_in() ) :
?>
    <p>You must be logged in to access your profile.</p>
    <a href="/login" class="button">Login</a>

<?php else :

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

<div class="md-profile-wrapper">

    <h2>My Profile</h2>

    <?php if ($updated): ?>
        <div class="md-success">Your profile was updated successfully.</div>
    <?php endif; ?>

    <form method="post" class="md-profile-form">

        <h3>Personal Information</h3>

        <p>
            <label>Full Name</label><br>
            <input type="text" name="display_name" value="<?php echo esc_attr($user->display_name); ?>" required>
        </p>

        <p>
            <label>Email</label><br>
            <input type="email" name="user_email" value="<?php echo esc_attr($user->user_email); ?>" required>
        </p>

        <?php wp_nonce_field('md_profile_update_action', 'md_profile_nonce'); ?>
        <button type="submit" name="md_update_profile" class="button button-primary">Save Profile</button>
    </form>

    <hr>

    <h3>Membership Information</h3>

    <p><strong>Plan:</strong> <?php echo esc_html($membership_name); ?></p>
    <p><strong>Status:</strong> <?php echo esc_html($membership_status); ?></p>
    <p><strong>Expires On:</strong> <?php echo esc_html($expiry_text); ?></p>

    <?php if ( $membership_id ) : ?>
        <a href="/membership-upgrade" class="button">Upgrade Membership</a>

        <form method="post" class="md-cancel-form">
            <?php wp_nonce_field('md_cancel_membership', 'md_cancel_nonce'); ?>
            <button type="submit" name="md_cancel_membership" class="button md-cancel-btn">
                Cancel Membership
            </button>
        </form>
    <?php else : ?>
        <a href="/membership-levels" class="button">Choose a Membership</a>
    <?php endif; ?>

    <hr>

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

<?php endif; ?>
<?php
function md_get_user_payments($user_id) {
    global $wpdb;

    $table = $wpdb->prefix . 'md_payments';

    return $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM $table WHERE user_id = %d ORDER BY created_at DESC", $user_id)
    );
}

?>
