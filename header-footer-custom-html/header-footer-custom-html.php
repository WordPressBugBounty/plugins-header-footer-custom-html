<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.enweby.com/
 * @since             1.0.0
 * @package           Header_Footer_Custom_Html
 *
 * @wordpress-plugin
 * Plugin Name:       Header Footer Custom Html
 * Plugin URI:        https://wordpress.org/plugins/header-footer-custom-html
 * Description:       A lightweight plugin by Enweby. This plugin enables admin to add custom html in either header or footer or both. This plugin is a great tool to add notifications like Ongoing sale notification, cookie use notification, possibility is endless.
 * Version:           2.0.1
 * Author:            Enweby
 * Author URI:        https://www.enweby.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       header-footer-custom-html
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

	if ( ! function_exists( 'enwbhfch_fs' ) ) {
		// Create a helper function for easy SDK access.
		function enwbhfch_fs() {
			global $enwbhfch_fs;

			if ( ! isset( $enwbhfch_fs ) ) {
				// Include Freemius SDK.
				require_once dirname(__FILE__) . '/freemius/start.php';

				$enwbhfch_fs = fs_dynamic_init( array(
					'id'                  => '13542',
					'slug'                => 'header-footer-custom-html',
					'type'                => 'plugin',
					'public_key'          => 'pk_b66708956e89fe189634fed3c9220',
					'is_premium'          => false,
					'has_addons'          => false,
					'has_paid_plans'      => false,
					'menu'                => array(
						'slug'           => 'header-footer-custom-html',
						'account'        => false,
						'support'        => false,
					),
					//disable optin Screeen.
					'anonymous_mode'	  => true,
				) );
			}

			return $enwbhfch_fs;
		}

		// Init Freemius.
		enwbhfch_fs();
		// remove a permission from persmission list from optin screen
		enwbhfch_fs()->add_filter( 'permission_list', 'enwbhfch_remove_extensions_permission' );
		// Not like register_uninstall_hook(), you do NOT have to use a static function.
		enwbhfch_fs()->add_action( 'after_uninstall', 'enwbhfch_fs_uninstall_cleanup' );
		// Signal that SDK was initiated.
		do_action( 'enwbhfch_fs_loaded' );
	}
	
	/***.. Your plugin's main file logic starts here...*/
	
	if ( ! function_exists( 'enwbhfch_fs_uninstall_cleanup' ) ) {
		/**
		 * Uninstall Cleanup
		 */
		function enwbhfch_fs_uninstall_cleanup() {        }
	}

	/**
	 * Removing extension info permission from optin screen
	 *
	 * @since    1.0.2
	 */
	function enwbhfch_remove_extensions_permission( $permissions ) {
		foreach ( $permissions as $key => $val ) {
			if ( $val['id'] !== 'extensions' ) {
				continue;
			}

			unset( $permissions[ $key ] );

			break;
		}

		return $permissions;
	}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'HEADER_FOOTER_CUSTOM_HTML_VERSION', '2.0.1' );

/**
 * Plugin base name.
 * used to locate plugin resources primarily code files
 * Start at version 1.0.0
 */
define( 'HEADER_FOOTER_CUSTOM_HTML_BASE_NAME', plugin_basename( __FILE__ ) );

/**
 * Plugin base dir path.
 * used to locate plugin resources primarily code files
 * Start at version 1.0.0
 */
defined( 'HEADER_FOOTER_CUSTOM_HTML_DIR' ) || define( 'HEADER_FOOTER_CUSTOM_HTML_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Plugin base dir path.
 */
define( 'HEADER_FOOTER_CUSTOM_HTML_PLUGIN_NAME', 'header-footer-custom-html' );

/**
 * Plugin base dir path.
 */
define( 'HEADER_FOOTER_CUSTOM_HTML_PLUGIN_VERSION', '2.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-header-footer-custom-html-activator.php
 */
function activate_header_footer_custom_html() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-header-footer-custom-html-activator.php';
	Header_Footer_Custom_Html_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-header-footer-custom-html-deactivator.php
 */
function deactivate_header_footer_custom_html() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-header-footer-custom-html-deactivator.php';
	Header_Footer_Custom_Html_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_header_footer_custom_html' );
register_deactivation_hook( __FILE__, 'deactivate_header_footer_custom_html' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-header-footer-custom-html.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_header_footer_custom_html() {

	$plugin = new Header_Footer_Custom_Html();
	$plugin->run();

}
run_header_footer_custom_html();
