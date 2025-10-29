<?php
/**
 * Admin area view for the plugin
 *
 * @link       https://mydevitsolutions.com
 * @since      1.0.0
 * @package    Membership
 * @subpackage Membership/admin/partials
 */
 // Get the WordPress database object
global $wpdb;
?>
<?php 
// Query the wp_md_member table to get member data
$members = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}md_member ORDER BY user_id DESC");


?>

<div class="wrap members-cm members-level">
  <h1>My Membership</h1>

  <div class="tabs">
    <div class="tab-button active" onclick="showTab(event, 'members')">Members</div>
    <div class="tab-button" onclick="showTab(event, 'active-members')">Active Members</div>
    <div class="tab-button" onclick="showTab(event, 'expired-members')">Expired Members</div>
  </div>

  <div id="members" class="tab-content active">
    <form method="get" action="">
      <!-- Filter -->
      <div class="filter-bar">
        <select name="account_state" id="account_state">
          <option value="">Account State</option>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
          <option value="pending">Pending</option>
        </select>
        <select name="membership_level" id="membership_level">
          <option value="">Membership Level</option>
          <option value="gold">Gold</option>
          <option value="silver">Silver</option>
          <option value="bronze">Bronze</option>
        </select>
        <input type="text" name="search" id="search" placeholder="Search...">
        <button type="submit">Search</button>
      </div>

      <!-- Table -->
      <table class="wp-list-table widefat fixed striped table-view-list roles">
        <thead>
          <tr>
            <td id="cb" class="check-column">
              <input id="cb-select-all-1" type="checkbox">
              <label for="cb-select-all-1">
                <span class="screen-reader-text">Select All</span>
              </label>
            </td>
            <th id="title" class="sortable asc">Username</th>
            <th id="email" class="sortable desc">Email</th>
            <th id="users">Membership Level</th>
			<th id="transactions">Transactions</th>
			<th id="subscriptions">Subscriptions</th>
            <th id="access-start">Access Starts</th>
            <th id="account-state">Status</th>
            
			

          </tr>
        </thead>

        <tbody id="the-list">
		<?php foreach ($members as $member) { 
		
			// Retrieve the user object using get_user_by()
			$user = get_user_by('id', $member->user_id);
			
			// Check if the user exists
			if ($user) {
				$username = $user->user_login; // Get the username (user_login)
				$email = $user->user_email;    // Get the email address (user_email)
				
			   
			} else {
				$username = ''; 
				$email = '';   
			}
		?>
          <tr data-user-id="<?php echo esc_attr($member->user_id); ?>">
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong><?php echo esc_html($username); ?></strong>
              <div class="row-actions">
                <span class="edit"><a href="<?php echo esc_url( get_edit_user_link( $member->user_id ) ); ?>">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td><?php echo esc_html($email); ?></td>
            <td><?php echo esc_html($member->membership_level); ?></td>
			
			<td>mp-txn-69017bc4b308f</td>
            <td>mp-sub-69017bc6b0c2c</td>
            <td>Pending</td>
            <td>Comment..</td>
          </tr>
		<?php } ?>
          

         

          

        
        </tbody>
      </table>
    </form>
  </div>

  <!-- Other Tabs -->
<?php $active_members = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}md_member WHERE status = %s ORDER BY user_id DESC",
        'active'
    )
);
?>
<div id="active-members" class="tab-content">
  <form method="get" action="">
      <!-- Filter -->
      <div class="filter-bar">
        <select name="account_state" id="account_state">
          <option value="">Account State</option>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
          <option value="pending">Pending</option>
        </select>
        <select name="membership_level" id="membership_level">
          <option value="">Membership Level</option>
          <option value="gold">Gold</option>
          <option value="silver">Silver</option>
          <option value="bronze">Bronze</option>
        </select>
        <input type="text" name="search" id="search" placeholder="Search...">
        <button type="submit">Search</button>
      </div>

      <!-- Table -->
      <table class="wp-list-table widefat fixed striped table-view-list roles">
        <thead>
          <tr>
            <td id="cb" class="check-column">
              <input id="cb-select-all-1" type="checkbox">
              <label for="cb-select-all-1">
                <span class="screen-reader-text">Select All</span>
              </label>
            </td>
            <th id="title" class="sortable asc">Username</th>
            <th id="email" class="sortable desc">Email</th>
            <th id="users">Membership Level</th>
			<th id="transactions">Transactions</th>
			<th id="subscriptions">Subscriptions</th>
            <th id="access-start">Access Starts</th>
            <th id="account-state">Status</th>
            
			

          </tr>
        </thead>

        <tbody id="the-list">
		<?php foreach ($active_members as $member) { 
		
			// Retrieve the user object using get_user_by()
			$user = get_user_by('id', $member->user_id);
			
			// Check if the user exists
			if ($user) {
				$username = $user->user_login; // Get the username (user_login)
				$email = $user->user_email;    // Get the email address (user_email)
				
			   
			} else {
				$username = ''; 
				$email = '';   
			}
		?>
          <tr data-user-id="<?php echo esc_attr($member->user_id); ?>">
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong><?php echo esc_html($username); ?></strong>
              <div class="row-actions">
                <span class="edit"><a href="<?php echo esc_url( get_edit_user_link( $member->user_id ) ); ?>">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td><?php echo esc_html($email); ?></td>
            <td><?php echo esc_html($member->membership_level); ?></td>
			
			<td>mp-txn-69017bc4b308f</td>
            <td>mp-sub-69017bc6b0c2c</td>
            <td>Pending</td>
            <td>Comment..</td>
          </tr>
		<?php } ?>
          

         

          

        
        </tbody>
      </table>
    </form>
  </div>
<?php $expired_members = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}md_member WHERE status = %s ORDER BY user_id DESC",
        'expired'
    )
);
?>
  <div id="expired-members" class="tab-content">
   <form method="get" action="">
      <!-- Filter -->
      <div class="filter-bar">
        <select name="account_state" id="account_state">
          <option value="">Account State</option>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
          <option value="pending">Pending</option>
        </select>
        <select name="membership_level" id="membership_level">
          <option value="">Membership Level</option>
          <option value="gold">Gold</option>
          <option value="silver">Silver</option>
          <option value="bronze">Bronze</option>
        </select>
        <input type="text" name="search" id="search" placeholder="Search...">
        <button type="submit">Search</button>
      </div>

      <!-- Table -->
      <table class="wp-list-table widefat fixed striped table-view-list roles">
        <thead>
          <tr>
            <td id="cb" class="check-column">
              <input id="cb-select-all-1" type="checkbox">
              <label for="cb-select-all-1">
                <span class="screen-reader-text">Select All</span>
              </label>
            </td>
            <th id="title" class="sortable asc">Username</th>
            <th id="email" class="sortable desc">Email</th>
            <th id="users">Membership Level</th>
			<th id="transactions">Transactions</th>
			<th id="subscriptions">Subscriptions</th>
            <th id="access-start">Access Starts</th>
            <th id="account-state">Status</th>
            
			

          </tr>
        </thead>

        <tbody id="the-list">
		<?php foreach ($expired_members as $member) { 
		
			// Retrieve the user object using get_user_by()
			$user = get_user_by('id', $member->user_id);
			
			// Check if the user exists
			if ($user) {
				$username = $user->user_login; // Get the username (user_login)
				$email = $user->user_email;    // Get the email address (user_email)
				
			   
			} else {
				$username = ''; 
				$email = '';   
			}
		?>
          <tr data-user-id="<?php echo esc_attr($member->user_id); ?>">
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong><?php echo esc_html($username); ?></strong>
              <div class="row-actions">
                <span class="edit"><a href="<?php echo esc_url( get_edit_user_link( $member->user_id ) ); ?>">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td><?php echo esc_html($email); ?></td>
            <td><?php echo esc_html($member->membership_level); ?></td>
			
			<td>mp-txn-69017bc4b308f</td>
            <td>mp-sub-69017bc6b0c2c</td>
            <td>Pending</td>
            <td>Comment..</td>
          </tr>
		<?php } ?>
          

         

          

        
        </tbody>
      </table>
    </form>
  </div>
</div>

<!-- Bulk Action -->



<script>
  function showTab(event, tabId) {
    document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    event.target.classList.add('active');
  }

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

  // Checkbox logic
  const selectAll = document.getElementById('selectAll');
  const rowCheckboxes = document.querySelectorAll('.rowCheckbox');

  selectAll.addEventListener('change', () => {
    rowCheckboxes.forEach(cb => cb.checked = selectAll.checked);
  });

  rowCheckboxes.forEach(cb => {
    cb.addEventListener('change', () => {
      const allChecked = [...rowCheckboxes].every(cb => cb.checked);
      const anyChecked = [...rowCheckboxes].some(cb => cb.checked);
      selectAll.checked = allChecked;
      selectAll.indeterminate = !allChecked && anyChecked;
    });
  });

  function applyBulkAction() {
    const selected = [...document.querySelectorAll('.rowCheckbox:checked')];
    const action = document.getElementById("bulkActionTop").value;

    if (!action) return alert("Please select a bulk action.");
    if (selected.length === 0) return alert("Please select at least one row.");

    const titles = selected.map(cb => cb.dataset.title).join(", ");
    alert(`Action "${action}" applied to: ${titles}`);
  }
  
</script>

