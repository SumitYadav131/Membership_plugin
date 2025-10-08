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

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
  <h1>Membership Settings</h1>

  <!-- Membership Settings Form -->
  <form id="membership-settings-form" style="max-width: 700px; background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 30px;">
    <h2 style="margin-top: 0;">Add / Update Membership Plan</h2>

    <div style="margin-bottom: 15px;">
      <label for="plan_name" style="font-weight: bold; display:block; margin-bottom: 5px;">Plan Name</label>
      <input type="text" id="plan_name" name="plan_name" placeholder="e.g. Gold Plan" style="width:100%; padding: 8px;" required>
    </div>

    <div style="margin-bottom: 15px;">
      <label for="plan_price" style="font-weight: bold; display:block; margin-bottom: 5px;">Price</label>
      <input type="number" id="plan_price" name="plan_price" placeholder="e.g. 499" style="width:100%; padding: 8px;" required>
    </div>

    <div style="margin-bottom: 15px;">
      <label for="plan_duration" style="font-weight: bold; display:block; margin-bottom: 5px;">Duration (in days)</label>
      <input type="number" id="plan_duration" name="plan_duration" placeholder="e.g. 30" style="width:100%; padding: 8px;" required>
    </div>

    <div style="margin-bottom: 15px;">
      <label for="plan_description" style="font-weight: bold; display:block; margin-bottom: 5px;">Description</label>
      <textarea id="plan_description" name="plan_description" rows="4" style="width:100%; padding: 8px;" placeholder="Describe this membership plan"></textarea>
    </div>

    <button type="submit" class="button button-primary">Save Membership Plan</button>
  </form>

  <!-- Membership Plans Table -->
  <h2>Available Membership Plans</h2>

    <table class="wp-list-table widefat fixed striped table-view-list roles">
        <thead>
          <tr>
            <td id="cb" class="check-column">
              <input id="cb-select-all-1" type="checkbox">
              <label for="cb-select-all-1">
                <span class="screen-reader-text">Select All</span>
              </label>
            </td>
            <th id="id">Id</th>
            <th id="title" class="sortable asc">Plan Name</th>
            <th id="Price" >Price</th>
            <th id="duration">Duration</th>
            <th id="sescription">Description</th>
            <th id="action">Action</th>
          </tr>
        </thead>

        <tbody id="the-list">
          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td>1</td>            
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Gold Plan</strong>
            </td>
            <td>$499</td>
            <td>300 days</td>
            <td>Access to premium content</td>
            <td><a href="#" class="button">Edit</a></td>
          </tr>


          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td>2</td>            
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Silver Plan</strong>
            </td>
            <td>$399</td>
            <td>200 days</td>
            <td>Access to premium content</td>
            <td><a href="#" class="button">Edit</a></td>
          </tr>


          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td>3</td>            
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Bronze</strong>
            </td>
            <td>$299</td>
            <td>100 days</td>
            <td>Access to premium content</td>
            <td><a href="#" class="button">Edit</a></td>
          </tr>


          <tr>
            <th scope="row" class="check-column">
              <input type="checkbox" name="roles[client]" value="client">
            </th>
            <td>4</td>            
            <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
              <strong>Testing</strong>
            </td>
            <td>Free</td>
            <td>10 days</td>
            <td>Access to premium content</td>
            <td><a href="#" class="button">Edit</a></td>
          </tr>
         
        </tbody>
      </table>
