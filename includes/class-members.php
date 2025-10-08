<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://mydevitsolutions.com
 * @since      1.0.0
 *
 * @package    Membership
 * @subpackage Membership/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Membership
 * @subpackage Membership/includes
 * @author     Sumit Yadav <mydevitdevelopers@gmail.com>
 */
class Members {



	public function __construct() {
		if ( defined( 'MEMBERSHIP_VERSION' ) ) {
			$this->version = MEMBERSHIP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'membership';
        //Admin menu hook.
        add_action('admin_menu', array(&$this, 'plugin_menu'));
		

	}

	
	public function handle_member_page() {
	echo 'This is Members page';
	}

	

}
