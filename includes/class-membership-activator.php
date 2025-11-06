<?php

/**
 * Fired during plugin activation
 *
 * @link       https://mydevitsolutions.com
 * @since      1.0.0
 *
 * @package    Membership
 * @subpackage Membership/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Membership
 * @subpackage Membership/includes
 * @author     Sumit Yadav <mydevitdevelopers@gmail.com>
 */
class Membership_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		 global $wpdb;

        $table_name = $wpdb->prefix . "md_membership_levels";

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            name varchar(200) NOT NULL,
            role varchar(100) NOT NULL,
            access_duration_type varchar(50) NOT NULL,
            access_duration_value int(11) DEFAULT 0,
            fixed_expiry_date date DEFAULT NULL,
            status varchar(20) DEFAULT 'active',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
		
		
		// create member table 
		
		   $table_name = $wpdb->prefix . 'md_member';
		   $charset_collate = $wpdb->get_charset_collate();

		$sql1 = "CREATE TABLE $table_name (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			user_id BIGINT(20) UNSIGNED NOT NULL,
			membership_level VARCHAR(100) NOT NULL,
			status VARCHAR(50) DEFAULT 'Active',
			access_start DATE DEFAULT NULL,
			member_since DATE DEFAULT NULL,
			gender VARCHAR(20) DEFAULT NULL,
			phone VARCHAR(50) DEFAULT NULL,
			street VARCHAR(255) DEFAULT NULL,
			city VARCHAR(100) DEFAULT NULL,
			state VARCHAR(100) DEFAULT NULL,
			zipcode VARCHAR(20) DEFAULT NULL,
			country VARCHAR(100) DEFAULT NULL,
			company VARCHAR(150) DEFAULT NULL,
			admin_notes TEXT DEFAULT NULL,
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY user_id (user_id)
		) $charset_collate;";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql1);
	
		// create new table 
		$table_name = $wpdb->prefix . 'md_subscriptions';
		$charset_collate = $wpdb->get_charset_collate();

		$sql2 = "CREATE TABLE $table_name (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			user_id BIGINT(20) UNSIGNED NOT NULL,
			membership_id VARCHAR(100) NOT NULL,
			price DECIMAL(10,2) NOT NULL DEFAULT '0.00',
			total DECIMAL(10,2) NOT NULL DEFAULT '0.00',
			gateway VARCHAR(100) DEFAULT NULL,
			period_type VARCHAR(50) DEFAULT NULL,
			status VARCHAR(50) DEFAULT NULL,
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY user_id (user_id),
			KEY membership_id (membership_id)
		) $charset_collate;";
		 dbDelta($sql2);
	}

}


