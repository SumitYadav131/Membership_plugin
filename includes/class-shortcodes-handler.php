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



	
}
 // Initialize the class
$shortcodesHandler = new ShortcodesHandler();
?>