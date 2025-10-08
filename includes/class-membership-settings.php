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
class Members_Settings {



	private static $_this;
	private $settings;
	public $current_tab;
	

	private function __construct() {
		$this->settings = (array) get_option( 'membership-settings' );
	}

	public static function get_instance() {
		self::$_this = empty( self::$_this ) ? new Members_Settings() : self::$_this;
		return self::$_this;
	}
	
	public function get_value( $key, $default = '' ) {
		if ( isset( $this->settings[ $key ] ) ) {
			return $this->settings[ $key ];
		}
		return $default;
	}

	public function set_value( $key, $value ) {
		$this->settings[ $key ] = $value;
		return $this;
	}

	public function save() {
		update_option( 'membership-settings', $this->settings );
	}


}
