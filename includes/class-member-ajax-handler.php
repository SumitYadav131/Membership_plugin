<?php
class MemberajaxHandler {

	public $execution_success_notice = false;

	public $success_notice_pw_reset = false;

	public function __construct() {
		//Shortcode for the registration, login and profile forms
		add_action('wp_ajax_md_delete_member', array(&$this, 'md_handle_delete_member'));
		add_action('wp_ajax_md_delete_member_level', array(&$this, 'md_handle_delete_membershiplevel'));
		
	}

	public function md_handle_delete_member() {
			
			

		// Get the user ID to delete
		if (isset($_POST['user_id'])) {
			$user_id = intval($_POST['user_id']);

			// Delete the member from wp_md_member table
			global $wpdb;
			$table_name = $wpdb->prefix . 'md_member';
			//$wpdb->delete($table_name, array('user_id' => $user_id));

			// Delete the user from wp_users table
			//wp_delete_user($user_id);

			wp_send_json_success(array('message' => 'Member deleted successfully.'));
		} else {
			wp_send_json_error(array('message' => 'User ID not provided.'));
		}
	}
	
	// Membership
	public function md_handle_delete_membershiplevel() {
			
			

		// Get the user ID to delete
		if (isset($_POST['level_id'])) {
			$level_id = intval($_POST['level_id']);

			// Delete the member from wp_md_member table
			global $wpdb;
			$table_name = $wpdb->prefix . 'md_membership_levels';
			$wpdb->delete($table_name, array('id' => $level_id));

		

			wp_send_json_success(array('message' => 'Membership deleted successfully.'));
		} else {
			wp_send_json_error(array('message' => 'Membership ID not provided.'));
		}
	}

	
	


	
}
 // Initialize the class
$MemberajaxHandler = new MemberajaxHandler();
?>