<?php
/**
 * Plugin Name: Premise Tabs
 * Description: Responsive CSS Tabs. Premise-WP add-on.
 * Plugin URI:  https://github.com/PremiseWP/premise-tabs
 * Version:     2.0.1
 * Author:      Vallgroup LLC
 * Author URI:  http://vallgroup.com
 * License:     GPL
 *
 * @package Premise Tabs
 */

defined( 'ABSPATH' ) or exit;


define( 'PTABS_PATH', plugin_dir_path( __FILE__ ) );

define( 'PTABS_URL', plugin_dir_url( __FILE__ ) );



// Instantiate our main class and setup Premise Tabs
// Must use 'plugins_loaded' hook.
add_action( 'plugins_loaded', array( Load_Premise_Tabs::get_instance(), 'ptabs_setup' ) );

/**
 * Load Premise Tabs plugin!
 *
 * This is Premise Tabs main class.
 */
class Load_Premise_Tabs {


	/**
	 * Plugin instance.
	 *
	 * @see get_instance()
	 *
	 * @var object
	 */
	protected static $instance = null;




	/**
	 * Constructor. Intentionally left empty and public.
	 *
	 * @see 	ptabs_setup()
	 */
	public function __construct() {}





	/**
	 * Access this plugin’s working instance
	 *
	 * @return  object instance of this class
	 */
	public static function get_instance() {

		null === self::$instance and self::$instance = new self;

		return self::$instance;
	}





	/**
	 * Throw error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @return void
	 */
	public function __clone() {

		// Cloning instances of the class is forbidden.
		exit;
	}




	/**
	 * Disable unserializing of the class.
	 *
	 * @return void
	 */
	public function __wakeup() {

		// Unserializing instances of the class is forbidden.
		exit;
	}





	/**
	 * Setup Premise Tabs
	 *
	 * Does includes, registers hooks & load language.
	 */
	public function ptabs_setup() {

		$this->do_includes();
		$this->ptabs_hooks();
	}






	/**
	 * Includes
	 */
	protected function do_includes() {

		// Require Premise WP.
		if ( ! class_exists( 'Premise_WP' ) ) {

			// Require Premise WP plugin with the help of TGM Plugin Activation.
			require_once PTABS_PATH . 'TGM-Plugin-Activation/class-tgm-plugin-activation.php';

			add_action( 'tgmpa_register', array( $this, 'ptabs_register_required_plugins' ) );
		}

		/**
		 * Models
		 */
		require_once PTABS_PATH . 'model/model-premise-tabs.php';
	}





	/**
	 * Premise Hooks
	 *
	 * Registers and enqueues scripts, adds classes to the body of DOM
	 */
	public function ptabs_hooks() {

		// Enqueue scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'ptabs_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'ptabs_scripts' ) );
	}




	/**
	 * Premise Tabs CSS & JS
	 *
	 * Premise Tabs loads 2 main files:
	 * Premise-Tabs.min.css, and Premise-Tabs.min.js.
	 *
	 * @author Dave Gandy http://twitter.com/davegandy
	 */
	public function ptabs_scripts() {

		// Register styles.
		wp_register_style( 'ptabs_style_css', PTABS_URL . 'css/Premise-Tabs.min.css', array() );

		// Register scripts.
		wp_register_script( 'ptabs_script_js', PTABS_URL . 'js/Premise-Tabs.min.js', array( 'jquery' ) );

		// Enqueue our styles and scripts for both admin and frontend.
		wp_enqueue_style( 'ptabs_style_css' );
		wp_enqueue_script( 'ptabs_script_js' );
	}





	/**
	 * Register the required plugins for this theme.
	 *
	 * We register one plugin:
	 * - Premise-WP from a GitHub repository
	 *
	 * @link https://github.com/PremiseWP/Premise-WP
	 */
	function ptabs_register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			// Include Premise-WP plugin.
			array(
				'name'               => 'Premise-WP', // The plugin name.
				'slug'               => 'Premise-WP', // The plugin slug (typically the folder name).
				'source'             => 'https://github.com/PremiseWP/Premise-WP/archive/master.zip', // The plugin source.
				'required'           => true, // If false, the plugin is only 'recommended' instead of required.
				// 'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
				'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				// 'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				// 'external_url'       => '', // If set, overrides default API URL and points to an external URL.
				// 'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
			),
		);

		/*
		 * Array of configuration settings.
		 */
		$config = array(
			'id'           => 'ptabs-tgmpa',         // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'plugins.php',            // Parent menu slug.
			'capability'   => 'install_plugins',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => true,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}
}
