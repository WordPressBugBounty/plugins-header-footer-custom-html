<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.enweby.com/
 * @since      1.0.0
 *
 * @package    Header_Footer_Custom_Html
 * @subpackage Header_Footer_Custom_Html/includes
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
 * @package    Header_Footer_Custom_Html
 * @subpackage Header_Footer_Custom_Html/includes
 * @author     Enweby <support@enweby.com>
 */
class Header_Footer_Custom_Html {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Header_Footer_Custom_Html_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'HEADER_FOOTER_CUSTOM_HTML_VERSION' ) ) {
			$this->version = HEADER_FOOTER_CUSTOM_HTML_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'header-footer-custom-html';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_enwb_hfch_cpt_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Header_Footer_Custom_Html_Loader. Orchestrates the hooks of the plugin.
	 * - Header_Footer_Custom_Html_i18n. Defines internationalization functionality.
	 * - Header_Footer_Custom_Html_Admin. Defines all hooks for the admin area.
	 * - Header_Footer_Custom_Html_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-header-footer-custom-html-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-header-footer-custom-html-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-header-footer-custom-html-admin.php';

		/**
		 * The class responsible for the functionality of the hfch custom post type.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-header-footer-custom-html-admin-cpt.php';
		
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-header-footer-custom-html-public.php';

		$this->loader = new Header_Footer_Custom_Html_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Header_Footer_Custom_Html_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Header_Footer_Custom_Html_i18n();

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

		$plugin_admin = new Header_Footer_Custom_Html_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		// Admin menu and settings.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'plugin_menu_settings' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'menu_settings_using_helper' );
		$this->loader->add_action( 'after_boo_admin_settings', $plugin_admin, 'header_footer_custom_html_admin_sidebar' );
		
		//$this->loader->add_action( 'in_admin_header', $plugin_admin, 'remove_admin_notices', 20 );
		// Plugin Row Meta.
		$this->loader->add_action( 'plugin_action_links_' . HEADER_FOOTER_CUSTOM_HTML_BASE_NAME, $plugin_admin, 'plugin_action_links' );
		$this->loader->add_action( 'plugin_row_meta', $plugin_admin, 'plugin_row_meta', 10, 2 );

	}
	
	/**
	 * Register all of the hooks related to registering and managing a custom post type
	 * as well as customizing the admin columns.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_enwb_hfch_cpt_hooks() {

		$plugin_cpt = new Header_Footer_Custom_Html_CPT();

		$this->loader->add_action( 'init', $plugin_cpt, 'new_cpt_slide' );

		$this->loader->add_filter( 'manage_edit-enwb_hfch_settings_columns', $plugin_cpt, 'add_hfch_columns' );
		$this->loader->add_filter( 'manage_enwb_hfch_settings_posts_custom_column', $plugin_cpt, 'add_hfch_columns_content', 10, 2 );
		$this->loader->add_action( 'add_meta_boxes', $plugin_cpt, 'hfch_header_html_register_meta_boxes' );	
		$this->loader->add_action( 'save_post', $plugin_cpt, 'metabox_save_hfch_meta', 10, 3 );
		//enqueing plugin's admin scripts
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_cpt, 'enwb_admin_enqueue_scripts' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_cpt, 'codemirror_enqueue_scripts' );		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Header_Footer_Custom_Html_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		// Custom html, script and styles.
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enweby_get_custom_css', 20 );
		$this->loader->add_action( 'wp_head', $plugin_public, 'enweby_get_custom_script_header', 200 );
		$this->loader->add_action( 'wp_body_open', $plugin_public, 'enweby_get_custom_html_header', 10 );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'enweby_get_custom_html_footer', 5 );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'enweby_get_custom_script_footer', 200 );
		//page/post wise custom html, script and styles
		$this->loader->add_filter( 'enweby_get_custom_html_header_filter', $plugin_public, 'enweby_get_custom_html_header_single' );
		$this->loader->add_filter( 'enweby_get_custom_html_footer_filter', $plugin_public, 'enweby_get_custom_html_footer_single' );
		$this->loader->add_filter( 'enweby_get_custom_script_header_filter', $plugin_public, 'enweby_get_custom_script_header_single' );
		$this->loader->add_filter( 'enweby_get_custom_script_footer_filter', $plugin_public, 'enweby_get_custom_script_footer_single' );
		$this->loader->add_filter( 'enweby_hfch_script_location_header_filter', $plugin_public, 'enweby_get_custom_script_render_location_single' );
		$this->loader->add_filter( 'enweby_hfch_script_location_footer_filter', $plugin_public, 'enweby_get_custom_script_render_location_single' );
		$this->loader->add_filter( 'enweby_get_custom_css_filter', $plugin_public, 'enweby_get_custom_css_single' );
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
	 * @return    Header_Footer_Custom_Html_Loader    Orchestrates the hooks of the plugin.
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

}
