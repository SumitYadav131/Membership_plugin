<?php
/**
 * Admin page: Update Membership Level
 */

global $wpdb;
$table_name = $wpdb->prefix . 'md_membership_levels';

// 1️⃣ Get the membership ID from the query string.
$membership_id = isset($_GET['mlevel_id']) ? intval($_GET['mlevel_id']) : 0;

// 2️⃣ Fetch the membership level data from the database.
$membership = null;
if ($membership_id > 0) {
    $membership = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $membership_id)
    );
}

// 3️⃣ Handle form submission (Update)
if (isset($_POST['update_membership_level'])) {
    $id = intval($_POST['membership_id']);
    $name = sanitize_text_field($_POST['membership-name']);
    $role = sanitize_text_field($_POST['wp-role']);
    $price = sanitize_text_field($_POST['membership-price']);
    $account_status = sanitize_text_field($_POST['default-status']);
    $email_activation = isset($_POST['email-activation']) ? 1 : 0;
    $redirect_url = esc_url_raw($_POST['redirect-page'] ?? '');
    $access_type = sanitize_text_field($_POST['recurring_time']);
    
    // Defaults
    $access_value = 'years';
    $fixed_expiry = '30';

    $updated = $wpdb->update(
        $table_name,
        [
            'name' => $name,
            'price' => $price,
            'role' => $role,
            'access_duration_type' => $access_type,
            'access_duration_value' => $access_value,
            'fixed_expiry_date' => $fixed_expiry,
            'status' => $account_status,
            'email_activation' => $email_activation,
            'redirect_url' => $redirect_url
        ],
        ['id' => $id],
        [
            '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s'
        ],
        ['%d']
    );

    if ($updated !== false) {
        echo '<div class="updated notice"><p>Membership Level updated successfully!</p></div>';
        // Refresh the data
        $membership = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id)
        );
    } else {
        echo '<div class="error notice"><p>Error updating Membership Level or no changes made.</p></div>';
    }
}
?>

<div class="wrap add-membership">
  <form method="post">
    <h1>Update Membership Level</h1>

    <input type="hidden" name="membership_id" value="<?php echo esc_attr($membership_id); ?>">

    <table class="form-table">
      <tr>
        <th><label for="membership-name">Membership Level Name <span style="color:red">*</span></label></th>
        <td>
          <input type="text" id="membership-name" name="membership-name" required
            value="<?php echo esc_attr($membership->name ?? ''); ?>">
        </td>
      </tr>

      <tr>
        <th><label for="membership-price">Membership Price <span style="color:red">*</span></label></th>
        <td>
          $<input type="number" id="membership-price" name="membership-price" required
            value="<?php echo esc_attr($membership->price ?? ''); ?>">
        </td>
      </tr>

      <tr>
        <th><label for="wp-role">Default WordPress Role <span style="color:red">*</span></label></th>
        <td>
          <select id="wp-role" name="wp-role">
            <?php 
              $roles = ['subscriber', 'editor', 'author'];
              foreach ($roles as $role) {
                printf(
                  '<option value="%s"%s>%s</option>',
                  esc_attr($role),
                  selected($membership->role ?? '', $role, false),
                  ucfirst($role)
                );
              }
            ?>
          </select>
        </td>
      </tr>

      <tr>
        <th>Recurring Duration <span style="color:red">*</span></th>
        <td>
          <select name="recurring_time" id="recurring_time">
            <?php 
              $durations = ['' => 'None', 'weekly' => 'Weekly', 'monthly' => 'Monthly', 'yearly' => 'Yearly'];
              foreach ($durations as $val => $label) {
                printf(
                  '<option value="%s"%s>%s</option>',
                  esc_attr($val),
                  selected($membership->access_duration_type ?? '', $val, false),
                  esc_html($label)
                );
              }
            ?>
          </select>
        </td>
      </tr>

      <tr>
        <th><label for="default-status">Default Account Status</label></th>
        <td>
          <select id="default-status" name="default-status">
            <?php 
              $statuses = ['global' => 'Use global settings', 'approved' => 'Approved', 'pending' => 'Pending'];
              foreach ($statuses as $key => $label) {
                printf(
                  '<option value="%s"%s>%s</option>',
                  esc_attr($key),
                  selected($membership->status ?? '', $key, false),
                  esc_html($label)
                );
              }
            ?>
          </select>
        </td>
      </tr>

      <tr>
        <th>Email Activation</th>
        <td>
          <label>
            <input type="checkbox" name="email-activation" id="email-activation" 
              <?php checked($membership->email_activation ?? 0, 1); ?>>
            Enable email activation
          </label>
        </td>
      </tr>

      <tr>
        <th><label for="redirect-page">Email Activation Redirect (optional)</label></th>
        <td>
          <input type="url" id="redirect-page" name="redirect-page"
            placeholder="https://example.com/after-activation"
            value="<?php echo esc_url($membership->redirect_url ?? ''); ?>">
        </td>
      </tr>
    </table>

    <p>
      <button class="button-primary" name="update_membership_level" type="submit">Update Membership Level</button>
    </p>
  </form>
</div>
