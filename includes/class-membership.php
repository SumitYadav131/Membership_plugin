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
class Membership {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Membership_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'MEMBERSHIP_VERSION' ) ) {
			$this->version = MEMBERSHIP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'membership';
        //Admin menu hook.
        add_action('admin_menu', array(&$this, 'plugin_menu'));
		add_action('save_post', array(&$this, 'save_postdata'));
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Membership_Loader. Orchestrates the hooks of the plugin.
	 * - Membership_i18n. Defines internationalization functionality.
	 * - Membership_Admin. Defines all hooks for the admin area.
	 * - Membership_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-membership-loader.php';
		
		include_once( MEMBERSHIP_PATH . 'includes/class-shortcodes-handler.php');
		include_once( MEMBERSHIP_PATH . 'includes/class-member-page-handler.php');
		include_once( MEMBERSHIP_PATH . 'includes/class-member-ajax-handler.php');
	
		
		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-membership-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-membership-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-membership-public.php';

		$this->loader = new Membership_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Membership_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Membership_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Membership_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Membership_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Membership_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	
	
	 public function plugin_menu() {
        $menu_parent_slug = 'my_membership';

        add_menu_page(__("WP Membership", 'simple-membership'), __("My Membership", 'my-membership'), 'manage_options', $menu_parent_slug, array(&$this, "admin_members_menu"), 'dashicons-id');
        add_submenu_page($menu_parent_slug, __("Members", 'my-membership'), __('Members', 'my-membership'), 'manage_options', 'my_wp_membership', array(&$this, "admin_add_members"));
        add_submenu_page($menu_parent_slug, __("Membership Levels", 'my-membership'), __("Membership Levels", 'my-membership'), 'manage_options', 'my_wp_membership_levels', array(&$this, "admin_membership_levels_menu"));
        add_submenu_page($menu_parent_slug, __("Settings", 'my-membership'), __("Settings", 'my-membership'), 'manage_options', 'my_wp_membership_settings', array(&$this, "admin_settings_menu"));
        add_submenu_page($menu_parent_slug, __("Payments", 'my-membership'), __("Payments", 'my-membership'), 'manage_options', 'my_wp_membership_payments', array(&$this, "admin_payments_menu"));
        add_submenu_page($menu_parent_slug, __("Tools", 'my-membership'), __("Tools", 'my-membership'), 'manage_options', 'my_wp_membership_tools', array(&$this, "admin_tools_menu"));
        add_submenu_page($menu_parent_slug, __("Reports", 'my-membership'), __("Reports", 'my-membership'), 'manage_options', 'my_wp_membership_reports', array(&$this, "admin_reports_menu"));
		$this->meta_box();

       
    }
	
	 /* Render the members menu in admin dashboard */

    public function admin_members_menu() {
		
		// Check if the query string contains 'action=edit'
    if ( isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) {
        // If the action is 'edit', include the edit version of the template
        include_once(MEMBERSHIP_PATH . 'admin/partials/membership-admin-display_edit.php');
    } else {
        // If the action is not 'edit' (or not set), include the default template
        include_once(MEMBERSHIP_PATH . 'admin/partials/membership-admin-display.php');
    }
		
       
      
    }
	 public function admin_add_members() {
        include_once(MEMBERSHIP_PATH. 'admin/partials/membership-add-member.php');
      
    }
	
	/* Render the membership levels menu in admin dashboard */

    public function admin_membership_levels_menu() {
        include_once(MEMBERSHIP_PATH. 'admin/partials/membership_levels_display.php');
       
    }
	
	/* Render the settings menu in admin dashboard */

    public function admin_settings_menu() {
        include_once(MEMBERSHIP_PATH. 'admin/partials/membership_settings_display.php');
       
    }
	
	/* Render the payments menu in admin dashboard */

    public function admin_payments_menu() {
        include_once(MEMBERSHIP_PATH. 'admin/partials/membership_payments_display.php');
       
    }
	/* Render the reports menu in admin dashboard */

    public function admin_reports_menu() {
        include_once(MEMBERSHIP_PATH. 'admin/partials/membership_reports_display.php');
       
    }
	
	/* Render the reports menu in admin dashboard */

    public function admin_tools_menu() {
        include_once(MEMBERSHIP_PATH. 'admin/partials/membership_tools_display.php');
       
    }
	
	 public function meta_box() {
        if (function_exists('add_meta_box')) {
            $post_types = get_post_types();
            foreach ($post_types as $post_type => $post_type) {
                add_meta_box('swpm_sectionid', __('MD Membership Protection', 'simple-membership'), array(&$this, 'inner_custom_box'), $post_type, 'advanced');
            }
        } else {//older version doesn't have custom post type so modification isn't needed.
            add_action('dbx_post_advanced', array(&$this, 'show_old_custom_box'));
            add_action('dbx_page_advanced', array(&$this, 'show_old_custom_box'));
        }
    }
	
	 public function inner_custom_box() {
        global $post, $wpdb;
        $id = $post->ID;
        
  
		$is_protected = get_post_meta($id, '_swpm_protected');
	    $default_membership_level = array();
	    

		//Nonce input
        echo '<input type="hidden" name="swpm_post_protection_box_nonce" value="' . wp_create_nonce('swpm_post_protection_box_nonce_action') . '" />';

        // The actual fields for data entry
        echo '<h4>' . __("Do you want to protect this content?", 'simple-membership') . '</h4>';
        echo '<input type="radio" ' . ((!$is_protected) ? 'checked' : "") . '  name="swpm_protect_post" value="1" /> ' . __('No, Do not protect this content.', 'simple-membership') . '<br/>';
        echo '<input type="radio" ' . (($is_protected) ? 'checked' : "") . '  name="swpm_protect_post" value="2" /> ' . __('Yes, Protect this content.', 'simple-membership') . '<br/>';
        

        echo '<h4>' . __("Select the membership level that can access this content:", 'simple-membership') . "</h4>";
        $query = "SELECT * FROM " . $wpdb->prefix . "md_membership_levels WHERE  id !=1 ";
        $levels = $wpdb->get_results($query, ARRAY_A);
		$selected_levels = get_post_meta($id, '_swpm_protection_levels', true);
	
        foreach ($levels as $level) {
			$is_checked = (is_array($selected_levels) && in_array($level['id'], $selected_levels)) ? true : false;

            echo '<input type="checkbox" ' . ($is_checked ? "checked='checked'" : "") .
            ' name="swpm_protection_level[' . $level['id'] . ']" value="' . $level['id'] . '" /> ' . $level['name'] . "<br/>";
        }
    }
	
	 public function save_postdata($post_id) {
		// Check if nonce is set and valid
		if (!isset($_POST['swpm_post_protection_box_nonce']) || !wp_verify_nonce($_POST['swpm_post_protection_box_nonce'], 'swpm_post_protection_box_nonce_action')) {
			return;
		}

		// Check if this is an autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
 
		// Don't save on revisions
		if (wp_is_post_revision($post_id)) return;

		// Ensure the post data is valid
		if (isset($_POST['swpm_protect_post'])) {
			// Protect or not protect the post
			$is_protected = $_POST['swpm_protect_post'] == '2' ? '1' : '0';
			update_post_meta($post_id, '_swpm_protected', $is_protected);
		}

		// Save the membership levels that can access this post
		if (isset($_POST['swpm_protection_level']) && is_array($_POST['swpm_protection_level'])) {
			$protection_levels = array_map('intval', $_POST['swpm_protection_level']);
			update_post_meta($post_id, '_swpm_protection_levels', $protection_levels);
		} else {
			// If no levels are selected, remove any existing protection levels
			delete_post_meta($post_id, '_swpm_protection_levels');
		}
	}


}
