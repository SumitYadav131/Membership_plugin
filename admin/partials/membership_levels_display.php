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
global $wpdb;
$table_name = $wpdb->prefix . 'md_membership_levels';

// Handle form submission
if (isset($_POST['add_membership_level'])) {
  $name = sanitize_text_field($_POST['membership-name']);
  $role = sanitize_text_field($_POST['wp-role']);
  $price = sanitize_text_field($_POST['membership-price']);
  $account_status = sanitize_text_field($_POST['default-status']);
  $email_activation = isset($_POST['email-activation']) ? 1 : 0;
  $redirect_url = esc_url_raw($_POST['redirect-page'] ?? '');
  $access_type = sanitize_text_field($_POST['recurring_time']);
  // Determine Access Duration
 
$access_value = 'years';
 $fixed_expiry = '30';
  $wpdb->insert($table_name, [
    'name' => $name,
	'price' => $price,
    'role' => $role,
    'access_duration_type' => $access_type,
    'access_duration_value' => $access_value,
    'fixed_expiry_date' => $fixed_expiry,
    'status' => $account_status,
    'email_activation' => $email_activation,
    'redirect_url' => $redirect_url
  ]);

  echo '<div class="updated notice"><p>Membership Level added successfully!</p></div>';
}
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap members-cm members-level">
  <h1 class="wp-heading-inline">Manage Members</h1><a href="#" class="page-title-action">Add Member</a>
  <br><br>
  <!-- Add Member Form -->

  <table class="wp-list-table widefat fixed striped table-view-list roles">
    <thead>
      <tr>
        <td id="cb" class="manage-column column-cb check-column">
          <input id="cb-select-all-1" type="checkbox">
          <label for="cb-select-all-1">
            <span class="screen-reader-text">Select All</span>
          </label>
        </td>
        <th id="member-level" class="column-primary sortable asc">
          Membership Level Name </th>
        <th id="member-role" class="sortable desc">Role</th>
        <th id="member-users">Users</th>
        <th id="member-duration">Access Duration</th>
        <th id="account-status">Created Date</th>
      </tr>
    </thead>

    <tbody id="the-list" data-wp-lists="list:role">
      <?php

      $levels = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC", ARRAY_A);

      foreach ($levels as $level) {

        ?>
        <tr>
          <th scope="row" class="check-column">
            <input type="checkbox" name="roles[client]" value="client">
          </th>
          <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
            <strong><?php echo $level['name']; ?></strong>
            <div class="row-actions">
              <span class="edit"><a href="<?php echo esc_url( 
    admin_url( 'admin.php?page=my_wp_membership_levels&action=edit&mlevel_id=' . intval($level['id']))); ?>">Edit</a> | </span>
              <span class="delete"><a href="#">Delete</a> | </span>
            </div>
          </td>
          <td><?php echo $level['role']; ?></td>
          <td><?php echo $level['access_duration_type']; ?></td>
          <td><?php echo $level['access_duration_value']; ?></td>
          <td><?php echo $level['created_at']; ?></td>
        </tr>
      <?php } ?>






    </tbody>
  </table>

</div>


<div class="wrap add-membership">
  <form method="post">
    <h1>Add Membership Level</h1>

    <table class="form-table">
      <tr>
        <th><label for="membership-name">Membership Level Name <span style="color:red">*</span></label></th>
        <td><input type="text" id="membership-name" name="membership-name" required></td>
      </tr>

      <tr>
        <th><label for="membership-price">Membership Price <span style="color:red">*</span></label></th>
        <td>$<input type="number" id="membership-price" name="membership-price" required></td>
      </tr>

      <tr>
        <th><label for="wp-role">Default WordPress Role <span style="color:red">*</span></label></th>
        <td>
          <select id="wp-role" name="wp-role">
            <option value="subscriber">Subscriber</option>
            <option value="editor">Editor</option>
            <option value="author">Author</option>
          </select>
        </td>
      </tr>
      <tr>
  <th>Recurring Duration <span style="color:red">*</span></th>
  <td>
  

    <label>
      
     
	  <select name="recurring_time" id="recurring_time">
	      <option value="">None</option>
		  <option value="weekly">weekly</option>
		  <option value="monthly">monthly</option>
		  <option value="yearly">yearly</option>
		  
	  </select>
    </label><br>

   
  </td>
</tr>

      <tr>
        <th><label for="default-status">Default Account Status</label></th>
        <td>
          <select id="default-status" name="default-status">
            <option value="global">Use global settings</option>
            <option value="approved">Approved</option>
            <option value="pending">Pending</option>
          </select>
          <span class="desc">Used for newly created members in this level.</span>
        </td>
      </tr>
      <tr>
        <th>Email Activation</th>
        <td>
          <label><input type="checkbox" id="email-activation"> Enable email activation</label>
          <span class="desc">Members will receive an activation link via email to complete registration.</span>
        </td>
      </tr>
      <tr>
        <th><label for="redirect-page">Email Activation Redirect (optional)</label></th>
        <td><input type="url" id="redirect-page" placeholder="https://example.com/after-activation"></td>
      </tr>
    </table>

    <p>
      <button class="button-primary" name="add_membership_level" type="submit">Add New Membership Level</button>
    </p>
  </form>
</div>


<script>
  // Enhanced Sorting Logic
  document.querySelectorAll("th.sortable").forEach(header => {
    header.addEventListener("click", () => {
      const table = header.closest("table");
      const tbody = table.querySelector("tbody");
      const headers = Array.from(header.parentNode.children);
      const index = headers.indexOf(header);
      const rows = Array.from(tbody.querySelectorAll("tr"));

      const isAsc = header.classList.contains("asc");
      document.querySelectorAll("th").forEach(th => th.classList.remove("asc", "desc"));
      header.classList.add(isAsc ? "desc" : "asc");

      const isNumeric = !isNaN(rows[0].children[index].textContent.trim());

      rows.sort((a, b) => {
        const A = a.children[index].textContent.trim();
        const B = b.children[index].textContent.trim();
        return isAsc
          ? (isNumeric ? B - A : B.localeCompare(A))
          : (isNumeric ? A - B : A.localeCompare(B));
      });

      rows.forEach(row => tbody.appendChild(row));
    });
  });    
</script>