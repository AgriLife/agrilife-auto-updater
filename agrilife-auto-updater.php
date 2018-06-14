<?php
/**
 * Plugin Name: AgriLife Auto Updater
 * Plugin URI: https://github.com/AgriLife/agrilife-auto-updater
 * Description: Handle automatic plugin updates
 * Version: 1.0.1
 * Author: Zach Watkins
 * Author URI: http://github.com/ZachWatkins
 * Author Email: zachary.watkins@ag.tamu.edu
 * License: GPL2+
 */

require 'vendor/autoload.php';

define( 'AG_AUUP_DIRNAME', 'agrilife-auto-updater' );
define( 'AG_AUUP_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'AG_AUUP_DIR_FILE', __FILE__ );
define( 'AG_AUUP_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'AG_AUUP_TEMPLATE_PATH', AG_AUUP_DIR_PATH . 'views' );

// Register plugin activation functions
$activate = new \AgriLife\AutoUpdate\Activate;
register_activation_hook( __FILE__, array( $activate, 'run') );

// Register plugin deactivation functions
$deactivate = new \AgriLife\AutoUpdate\Deactivate;
register_deactivation_hook( __FILE__, array( $deactivate, 'run' ) );

class Agrilife_AutoLoad {

	private static $instance = null;

	private $path = null;

	private $wpsf = null;

	public static function get_instance() {
		return null == self::$instance ? new self : self::$instance;
	}

	private function __construct() {

		// Save the plugin path
		$this->path = plugin_dir_path( __FILE__ );

		// Add the options page and menu item
		if( is_multisite() ){
	  	add_action( 'network_admin_menu', array( $this, 'plugin_network_admin_menu' ) );
		} else {
			add_action( 'admin_menu', array( $this, 'plugin_admin_menu' ) );
		}

		// Wrap in action like gravityforms.php
		add_action( 'init', function(){

			add_filter( 'auto_update_plugin', array( $this, 'auto_update_specific_plugins' ), 10, 2 );

		});

		// Log plugin update timestamp after a successful update
		add_action( 'automatic_updates_complete', array( $this, 'log_plugin_updates' ) );

		// Temporary change of updated plugin array keys
		// Remove tomorrow
		add_action( 'wp_maybe_auto_update', function(){

			// Get plugins
			$plugins = get_plugins();

			// Get transient
			$transient = get_site_transient('agrilife_auto_updater_true');

			foreach ($plugins as $main_file => $plugin) {

				$slug = $plugin['TextDomain'];
				$name = $plugin['name'];
				$pattern = '/\((Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday) (\d+)(st|nd|rd|th) of([^\)]+)\)/i';
				$replace = '$2$4';

				if(array_key_exists($slug, $transient)){

					// Set aside value
					$value = $transient[$slug];
					// Reverse value value back to milliseconds for sorting
					if(gettype($value) !== 'integer'){
						$value = preg_replace($pattern, $replace, $value);
						$value = strtotime($value);
					}
					// Unset old keyed values
					unset($transient[$slug]);
					// Set new keyed value
					$transient[$name] = $value;

				}

			}

			arsort($transient);

			set_site_transient( 'agrilife_auto_updater_true', $transient );

		});

	}

	public function auto_update_specific_plugins( $update, $item ) {

    set_site_transient('agrilife_auto_updater_triggered', date('l jS \of F Y h:i:s A'));

		// Array of plugin slugs to never auto-update
		$plugins = array (
			'acf',
			'gravityforms',
			'relevanssi',
			'soliloquy',
			'tablepress',
			'events-calendar-pro',
			'the-events-calendar',
			'user-role-editor-pro',
			'wp-document-revisions',
			'remove-date-from-permalink',
			'remove-workflow-states',
			'wpGoogleMaps',
			'wp-google-maps',
			'wp-google-maps-gold',
			'wp-google-maps-pro',
			'google-maps-builder'
		);

		if ( in_array( $item->slug, $plugins ) ) {

			return false;

		} else {

			return true;

		}

	}

	public function log_plugin_updates($update_results){

		foreach ($update_results as $key => $plugin) {

			$item = $plugin->item;

			if( property_exists($item, 'plugin') && $plugin->result){

				// This is a plugin and it was updated
				$this->set_plugin_update_time( 'agrilife_auto_updater_true', $plugin );

			}

		}

	}

	public function set_plugin_update_time($transient_name, $plugin){

		$transient = get_site_transient($transient_name);

		if(!$transient){
			$transient = array();
		}

		// As plugins update, rename the array key to a name value
		$item = $plugin->item;
		$name = $plugin->name;

		$transient[ $name ] = date('l jS \of F Y h:i:s A');

		set_site_transient($transient_name, $transient);

	}

	public function plugin_network_admin_menu() {

		require( 'vendor/Settings.php' );

		$this->wpsf = new Settings( $this->path . 'lib/plugin-settings.php' );

		add_submenu_page(
			'plugins.php',
			'Auto Updates',
			'Auto Updates',
			'manage_network',
			'auto-updates',
			array( $this, 'plugin_admin_page' )
		);

	}

	public function plugin_admin_menu() {

		require( 'vendor/Settings.php' );

		$this->wpsf = new Settings( $this->path . 'lib/plugin-settings.php' );

		add_submenu_page(
			'plugins.php',
			'Auto Updates',
			'Auto Updates',
			'manage_options',
			'auto-updates',
			array( $this, 'plugin_admin_page' )
		);

	}

	/**
	 * Renders the options page for this plugin.
	 */
	public function plugin_admin_page() {

		ob_start();

		$fields = $this->wpsf;
		include_once( 'views/admin.php' );

		$settings_page = ob_get_contents();
		ob_clean();

		echo $settings_page;

	}
}

Agrilife_AutoLoad::get_instance();
