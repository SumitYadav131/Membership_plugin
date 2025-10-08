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

       
    }
	
	 /* Render the members menu in admin dashboard */

    public function admin_members_menu() {
        include_once(MEMBERSHIP_PATH. 'admin/partials/membership-admin-display.php');
      
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

}
