<?php
class MemberajaxHandler {

	public $execution_success_notice = false;

	public $success_notice_pw_reset = false;

	public function __construct() {
		//Shortcode for the registration, login and profile forms
		add_action('wp_ajax_md_delete_member', array(&$this, 'md_handle_delete_member'));
		add_action('wp_ajax_md_delete_member_level', array(&$this, 'md_handle_delete_membershiplevel'));
		
		add_action('wp_ajax_nopriv_register_after_payment', array(&$this, 'register_after_payment_callback'));
		add_action('wp_ajax_register_after_payment', array(&$this, 'register_after_payment_callback'));
		
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
	
	public function register_after_payment_callback() {
	$name     = sanitize_text_field($_POST['member_name']);
	$email    = sanitize_email($_POST['member_email']);
	$password = sanitize_text_field($_POST['member_password']);
	$street   = sanitize_text_field($_POST['member_street']);
	$city     = sanitize_text_field($_POST['member_city']);
	$state    = sanitize_text_field($_POST['member_state']);
	$pincode  = sanitize_text_field($_POST['member_pincode']);
	$country  = sanitize_text_field($_POST['member_country']);
	$payment_id = sanitize_text_field($_POST['payment_id']);

	if (email_exists($email)) {
		wp_send_json(['success' => false, 'message' => 'Email already registered.']);
	}

	$user_id = wp_create_user($email, $password, $email);
	if (is_wp_error($user_id)) {
		wp_send_json(['success' => false, 'message' => $user_id->get_error_message()]);
	}

	wp_update_user(['ID' => $user_id, 'display_name' => $name]);
	update_user_meta($user_id, 'member_street', $street);
	update_user_meta($user_id, 'member_city', $city);
	update_user_meta($user_id, 'member_state', $state);
	update_user_meta($user_id, 'member_pincode', $pincode);
	update_user_meta($user_id, 'member_country', $country);
	update_user_meta($user_id, 'stripe_payment_id', $payment_id);

	wp_send_json(['success' => true]);
}

	
	


	
}
 // Initialize the class
$MemberajaxHandler = new MemberajaxHandler();
?>