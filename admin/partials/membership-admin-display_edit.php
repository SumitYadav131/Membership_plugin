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
  <h1>My Membership Edit page</h1>

  



  <!-- Other Tabs -->


 
</div>




