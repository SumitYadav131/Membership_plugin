<?php
/**
 * Admin area view for the plugin
 *
 * @link       https://mydevitsolutions.com
 * @since      1.0.0
 * @package    Membership
 * @subpackage Membership/admin/partials
 */
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
            <th id="access-start">Access Starts</th>
            <th id="account-state">Account State</th>
            <th id="note">Note</th>
          </tr>
        </thead>

        <tbody id="the-list">
          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Zsmith</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Zsmith1212@gmail.com</td>
            <td><a href="#">0</a></td>
            <td>2025-05-05</td>
            <td>Pending</td>
            <td>Verification pending</td>
          </tr>

          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Hanery</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Hanery2211@gmail.com</td>
            <td><a href="#">1</a></td>
            <td>2025-06-02</td>
            <td>Inactive</td>
            <td>Follow-up needed</td>
          </tr>

          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Larry</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Larry1255@gmail.com</td>
            <td><a href="#">2</a></td>
            <td>2025-07-08</td>
            <td>Pending</td>
            <td>Verification pending</td>
          </tr>

          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Rammpa</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Rammpa912@gmail.com</td>
            <td><a href="#">1</a></td>
            <td>2025-05-05</td>
            <td>Active</td>
            <td>VIP Client</td>
          </tr>       

          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Laura</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Laura422@gmail.com</td>
            <td><a href="#">3</a></td>
            <td>2025-05-05</td>
            <td>Pending</td>
            <td>VIP Client</td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>

  <!-- Other Tabs -->
  <div id="active-members" class="tab-content">
    <form method="get" action="">    
      <!-- Table -->
      <table class="wp-list-table widefat fixed striped table-view-list roles">
        <thead>
          <tr>
            <td id="cb" class="manage-column column-cb check-column">
              <input id="cb-select-all-1" type="checkbox">
              <label for="cb-select-all-1">
                <span class="screen-reader-text">Select All</span>
              </label>
            </td>
            <th scope="col" id="title" class="manage-column column-title column-primary sortable asc">Username</th>
            <th scope="col" id="role" class="manage-column column-role sortable desc">Email</th>
            <th scope="col" id="users" class="manage-column column-users">Membership Level</th>
            <th scope="col" id="access-state" class="manage-column column-granted_caps">Access Starts</th>
            <th scope="col" id="account-state" class="manage-column column-denied_caps">Account State</th>
            <th scope="col" id="note" class="manage-column column-denied_caps">Note</th>
          </tr>
        </thead>

        <tbody id="the-list" data-wp-lists="list:role">
          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Zsmith</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Zsmith1212@gmail.com</td>
            <td><a href="#">0</a></td>
            <td>2025-05-05</td>
            <td>Pending</td>
            <td>Verification pending</td>
          </tr>

          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Hanery</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Hanery2211@gmail.com</td>
            <td><a href="#">0</a></td>
            <td>2025-06-02</td>
            <td>Inactive</td>
            <td>Follow-up needed</td>
          </tr>

          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Larry</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Larry1255@gmail.com</td>
            <td><a href="#">0</a></td>
            <td>2025-07-08</td>
            <td>Pending</td>
            <td>Verification pending</td>
          </tr>

          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Rammpa</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Rammpa912@gmail.com</td>
            <td><a href="#">0</a></td>
            <td>2025-05-05</td>
            <td>Active</td>
            <td>VIP Client</td>
          </tr>       

          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Laura</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Laura422@gmail.com</td>
            <td><a href="#">0</a></td>
            <td>2025-05-05</td>
            <td>Pending</td>
            <td>VIP Client</td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>

  <div id="expired-members" class="tab-content">
    <form method="get" action="">    
      <!-- Table -->
      <table class="wp-list-table widefat fixed striped table-view-list roles">
        <thead>
          <tr>
            <td id="cb" class="manage-column column-cb check-column">
              <input id="cb-select-all-1" type="checkbox">
              <label for="cb-select-all-1">
                <span class="screen-reader-text">Select All</span>
              </label>
            </td>
            <th scope="col" id="title" class="manage-column column-title column-primary sortable asc">Username</th>
            <th scope="col" id="role" class="manage-column column-role sortable desc">Email</th>
            <th scope="col" id="users" class="manage-column column-users">Membership Level</th>
            <th scope="col" id="access-state" class="manage-column column-granted_caps">Access Starts</th>
            <th scope="col" id="account-state" class="manage-column column-denied_caps">Account State</th>
            <th scope="col" id="note" class="manage-column column-denied_caps">Note</th>
          </tr>
        </thead>

        <tbody id="the-list" data-wp-lists="list:role">
          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Msmith</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Msmith1212@gmail.com</td>
            <td><a href="#">0</a></td>
            <td>2025-05-05</td>
            <td>Pending</td>
            <td>Verification pending</td>
          </tr>

          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Danery</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Danery2211@gmail.com</td>
            <td><a href="#">0</a></td>
            <td>2025-06-02</td>
            <td>Inactive</td>
            <td>Follow-up needed</td>
          </tr>

          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Garry</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Garry1255@gmail.com</td>
            <td><a href="#">0</a></td>
            <td>2025-07-08</td>
            <td>Pending</td>
            <td>Verification pending</td>
          </tr>

          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Lammpa</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Lammpa912@gmail.com</td>
            <td><a href="#">0</a></td>
            <td>2025-05-05</td>
            <td>Active</td>
            <td>VIP Client</td>
          </tr>       

          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Maura</strong>
              <div class="row-actions">
                <span class="edit"><a href="#">Edit</a> | </span>
                <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
              </div>
            </td>
            <td>Maura422@gmail.com</td>
            <td><a href="#">0</a></td>
            <td>2025-05-05</td>
            <td>Pending</td>
            <td>VIP Client</td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
</div>

<!-- Bulk Action -->
<div class="bulk-bar">
  <select id="bulkActionTop" name="bulk_action">
    <option value="">Bulk actions</option>
    <option value="edit">Edit</option>
    <option value="trash">Move to Trash</option>
  </select>
  <button type="button" onclick="applyBulkAction()">Apply</button>
</div>


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
