<?php
class ShortcodesHandler {

	public $execution_success_notice = false;

	public $success_notice_pw_reset = false;

	public function __construct() {
		//Shortcode for the registration, login and profile forms
		add_shortcode("md_registration_form", array(&$this, 'registration_form'));
		add_shortcode('md_profile_form', array(&$this, 'profile_form'));
		add_shortcode('md_login_form', array(&$this, 'login_form_shortcode_output'));
		add_shortcode('md_membership_levels', array(&$this, 'display_membership_levels'));
		 // HANDLE LOGIN BEFORE OUTPUT
        add_action('init', array(&$this, 'process_login'));
		add_action('init', array(&$this, 'process_membership_cancel'));

	}

	public function registration_form( $args ) {
		extract(
			shortcode_atts(
				array(
					'id'          => '',
					'button_text' => '',
					'new_window'  => '',
					'class'       => '',
				),
				$args
			)
		);
         //Initialize the output variable.
		$output = '';
		$output .= '<h1>Hello Membersip plugin</h1>';
		

		//Return the final output.
		return $output;
	}

	
	public function display_membership_levels($atts) {
    global $wpdb;

    // Set default attributes for the shortcode
    $atts = shortcode_atts(array(
        'per_page' => 5, // Number of levels to display per page
        'order_by' => 'id', // Default sorting by 'id'
        'order' => 'ASC', // Default order is ascending
    ), $atts, 'membership_levels');

    // Fetch the membership levels from the custom database table
    $table_name = $wpdb->prefix . 'md_membership_levels';  // Assuming your table name is wp_memberships
    $query = $wpdb->prepare(
        "SELECT * FROM $table_name"  // Only fetch active memberships, you can change this as per your need
  
    );
    
    $membership_levels = $wpdb->get_results($query);

    // Start output buffer
    ob_start();

    if (!empty($membership_levels)) {
        echo '<div class="membership-levels">';

        // Loop through the membership levels
        foreach ($membership_levels as $level) {
            // Display each membership level's data
            $expiration_date = $level->fixed_expiry_date ? date('F j, Y', strtotime($level->fixed_expiry_date)) : 'No expiration';
            $role_name = ucfirst($level->role);  // Format the role name for display
            
            echo '<div class="membership-level">';
            echo '<h2>' . esc_html($level->name) . '</h2>';
            echo '<div class="description">' . esc_html($level->role) . '</div>';
            echo '<div class="price">Price: $' . esc_html($level->price) . '</div>';
            echo '<div class="duration">Access Duration: ' . esc_html($level->access_duration_value) . ' ' . esc_html($level->access_duration_type) . '</div>';
            echo '<div class="expiration">Expiration Date: ' . esc_html($expiration_date) . '</div>';
            echo '<div class="email-activation">Email Activation: ' . ($level->email_activation ? 'Yes' : 'No') . '</div>';

            // Add a "Subscribe" button (this should link to a payment gateway or subscription system)
            echo '<form method="post" action="#">';
            echo '<input type="hidden" name="membership_level" value="' . esc_attr($level->id) . '">';
            echo '<input type="submit" name="subscribe_membership" value="Subscribe Now">';
            echo '</form>';

            // Display redirect URL if exists
            if (!empty($level->redirect_url)) {
                echo '<a href="' . esc_url($level->redirect_url) . '" class="redirect-url">Redirect URL</a>';
            }

            echo '</div>'; // End membership-level div
        }

        echo '</div>'; // End membership-levels div
    } else {
        echo 'No membership levels found.';
    }

    // Return the content
    return ob_get_clean();
}

	public function login_form_shortcode_output() {
        ob_start();
		
        require MEMBERSHIP_PATH. 'templates/login-form.php';
        return ob_get_clean();
    }
	public function profile_form() {
        ob_start();
		
        require MEMBERSHIP_PATH. 'templates/profile-form.php';
        return ob_get_clean();
    }

public function process_login() {

    if ( isset($_POST['cmp_login_nonce']) &&
         wp_verify_nonce($_POST['cmp_login_nonce'], 'cmp_login') ) {

        $creds = [
            'user_login'    => sanitize_text_field($_POST['username']),
            'user_password' => sanitize_text_field($_POST['password']),
            'remember'      => true
        ];

        $user = wp_signon($creds, false);

        if ( is_wp_error($user) ) {
            wp_redirect(add_query_arg('login', 'failed', wp_get_referer()));
            exit;
        }

        wp_redirect(site_url('/my-account'));
        exit;
    }
}


public function process_membership_cancel() {

    if ( isset($_POST['md_cancel_membership']) &&
         wp_verify_nonce($_POST['md_cancel_nonce'], 'md_cancel_membership') ) {

        $user_id = get_current_user_id();

        // 1. Remove role
        $user = new WP_User($user_id);
        $user->set_role('subscriber');

        // 2. Mark membership canceled in meta
        update_user_meta($user_id, 'membership_status', 'canceled');

        wp_redirect(add_query_arg('updated', '1', wp_get_referer()));
        exit;
    }
}



	
}


 // Initialize the class
$shortcodesHandler = new ShortcodesHandler();
?>