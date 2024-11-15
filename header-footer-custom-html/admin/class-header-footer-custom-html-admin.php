<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.enweby.com/
 * @since      1.0.0
 *
 * @package    Header_Footer_Custom_Html
 * @subpackage Header_Footer_Custom_Html/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Header_Footer_Custom_Html
 * @subpackage Header_Footer_Custom_Html/admin
 * @author     Enweby <support@enweby.com>
 */
class Header_Footer_Custom_Html_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;


	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->load_notices_files();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Header_Footer_Custom_Html_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Header_Footer_Custom_Html_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/header-footer-custom-html-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Header_Footer_Custom_Html_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Header_Footer_Custom_Html_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/header-footer-custom-html-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	* Load core files.
	 */
	public function load_notices_files() {		
		if ( is_admin() ) {
				require_once plugin_dir_path( __dir__ ) . 'admin/lib/enwb-notices/class-enwb-hfch-notices.php';
			}

			include_once plugin_dir_path( __file__ ) . 'class-enwb-hfch-admin-notices.php';
	}
	
	/**
	 * Remove_all admin notices on plugin page.
	 */
	public function remove_admin_notices() {
		$screen = get_current_screen();
		if ( in_array( $screen->id, array( 'toplevel_page_header-footer-custom-html', 'enwb_hfch_settings', 'edit-enwb_hfch_settings' ), true ) ) {
			remove_all_actions( 'admin_notices' );
		}
	}

	/**
	 * To add Plugin Menu and Settings page
	 */
	public function plugin_menu_settings() {
		// Main Menu Item.
		add_menu_page(
			'Setup header footer global settings for custom html, CSS, & script',
			'Header footer Custom Html',
			'manage_options',
			'header-footer-custom-html',
			array( $this, 'header_footer_custom_html_main_menu' ),
			'dashicons-editor-code',
			60
		);
		add_submenu_page(
			'header-footer-custom-html',
			'Global Header footer Custom Html Settings',
			'Global Settings',
			'manage_options',
			'header-footer-custom-html',				
			'',
			1
		);
		add_submenu_page(
			'header-footer-custom-html',
			'Header footer Setting Records',
			'All HFCH Settings',
			'manage_options',
			'edit.php?post_type=enwb_hfch_settings',				
			'',
			2
		);
		add_submenu_page(
			'header-footer-custom-html',
			'Add New Header Footer Setting Item',
			'Add New',
			'manage_options',
			'post-new.php?post_type=enwb_hfch_settings',
			'',
			3
		);
		add_submenu_page(
			'header-footer-custom-html',
			'Plugin Documentation',
			'Documentation',
			'manage_options',
			'https://www.enweby.com/documentation/header-footer-custom-html-documentation/',
			'',
			4
		);	
	}

	/**
	 * Admin Page Display
	 */
	public function header_footer_custom_html_main_menu() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/header-footer-custom-html-admin-display.php';
		//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/hfch-main-menu.php';
	}
	
	/**
	 * Admin Page sidebar
	 */
	public function header_footer_custom_html_admin_sidebar() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/hfch-main-menu.php';
	}

	/**
	 * Setting plugin menu element
	 */
	public function menu_settings_using_helper() {

		require_once HEADER_FOOTER_CUSTOM_HTML_DIR . 'vendor/boo-settings-helper/class-boo-settings-helper.php';

		$header_footer_custom_html_settings = array(
			'tabs'     => true,
			'prefix'   => 'enweby_',
			'menu'     => array(
				'slug'       => 'header-footer-custom-html',
				'page_title' => __( 'Header Footer Custom Html', 'header-footer-custom-html' ),
				'menu_title' => __( 'Header Footer Custom Html', 'header-footer-custom-html' ),
				'parent'     => 'admin.php?page=header-footer-custom-html',
				'submenu'    => true,
			),
			'sections' => array(
				array(
					'id'    => 'hfch_header_section',
					'title' => __( 'Header Html Settings', 'header-footer-custom-html' ),
				),
				array(
					'id'    => 'hfch_footer_section',
					'title' => __( 'Footer Html Settings', 'header-footer-custom-html' ),
				),
				array(
					'id'    => 'hfch_script_css_section',
					'title' => __( 'Custom Script & Css Settings', 'header-footer-custom-html' ),
				),
			),
			'fields'   => array(
				'hfch_header_section'     => array(
					array(
						'id'      => 'hfch_apply_to_header_options',
						'label'   => __( 'Apply To', 'header-footer-custom-html' ),
						'type'    => 'select',
						'options' => array(
							'all'  => __( 'All Pages', 'header-footer-custom-html' ),
							'home' => __( 'Home Page Only', 'header-footer-custom-html' ),
							'page' => __( 'Specific Page', 'header-footer-custom-html' ),
							'post' => __( 'Specific post', 'header-footer-custom-html' ),
						),
					),
					array(
						'id'      => 'hfch_header_page_field_id',
						'label'   => __( 'Select Page', 'header-footer-custom-html' ),

						'type'    => 'pages',
						'options' => array(
							'post_type' => 'page',
						),
					),
					array(
						'id'      => 'hfch_header_post_field_id',
						'label'   => __( 'Select Post', 'header-footer-custom-html' ),
						'type'    => 'posts',
						'options' => array(
							'post_type' => 'post',
						),
					),
					array(
						'id'                => 'hfch_header_html',
						'label'             => __( 'Html for Header', 'header-footer-custom-html' ),
						'desc'              => __( 'Code will be inserted just before the header', 'header-footer-custom-html' ),
						'placeholder'       => __( 'Paste your html code here', 'header-footer-custom-html' ),
						'type'              => 'editor',
						'sanitize_callback' => 'sanitize_editor',
					),
					array(
						'id'      => 'hfch_header_html_sticky',
						'label'   => __( 'Stick Above Header Html code section to', 'header-footer-custom-html' ),
						'desc'    => __( 'Sticky option for above Header Html code section', 'header-footer-custom-html' ),
						'type'    => 'select',
						'default' => 'none',
						'options' => array(
							'none'  => 'None',
							'top'   => 'Top',
							'left'  => 'Left in header',
							'right' => 'Right in header',
						),
					),
					array(
						'id'                => 'hfch_header_bg_color',
						'label'             => __( 'Background color for Header Html', 'header-footer-custom-html' ),
						'desc'              => __( 'Default color is #FFA500', 'header-footer-custom-html' ),
						'type'              => 'color',
						'default'			=> '#FFA500',
						'sanitize_callback' => 'sanitize_editor',
					),
					array(
						'id'      => 'hfch_header_bg_image',
						'label'   => __( 'Background Image for Header Html', 'header-footer-custom-html' ),
						'desc'    => __( 'Background Image', 'header-footer-custom-html' ),
						'type'    => 'media',
						'default' => '',
						'options' => array(
							'btn'       => 'Add Media',
							'max_width' => 150,
						),
					),
					array(
						'id'      => 'hfch_header_html_bg_repeat',
						'label'   => __( "Header html background Image Repeat property", 'header-footer-custom-html' ),
						'desc'    => __( 'Image background-repeat property', 'header-footer-custom-html' ),
						'type'    => 'select',
						'default' => 'no-repeat',
						'options' => array(
							'no-repeat'  => 'No Repeat',
							'repeat'  => 'Repeat',
						),
					),
					array(
						'id'      => 'hfch_header_html_bg_position',
						'label'   => __( "Header html background Image position property", 'header-footer-custom-html' ),
						'desc'    => __( 'Image background-position property', 'header-footer-custom-html' ),
						'type'    => 'select',
						'default' => 'center',
						'options' => array(
							'top'  => 'Top',
							'center'  => 'Center',
							'bottom'  => 'Bottom',
						),
					),
					array(
						'id'      => 'hfch_header_html_bg_attachment',
						'label'   => __( "Header html image Background Attachement property", 'header-footer-custom-html' ),
						'desc'    => __( 'Image background-attachement property', 'header-footer-custom-html' ),
						'type'    => 'select',
						'default' => 'scroll',
						'options' => array(
							'scroll'  => 'Scroll',
							'fixed'  => 'Fixed',
							'initial'  => 'Initial',
							'inherit'  => 'Inherit',
						),
					),
					array(
						'id'      => 'hfch_header_html_bg_size',
						'label'   => __( "Header html image Background Size property", 'header-footer-custom-html' ),
						'desc'    => __( 'Image background-size property', 'header-footer-custom-html' ),
						'type'    => 'select',
						'default' => 'cover',
						'options' => array(
							'cover'  => 'Cover',
							'contain'  => 'Contain',
							'initial'  => 'Initial',
							'inherit'  => 'Inherit',
						),
					),
				),
				'hfch_footer_section'     => array(
					array(
						'id'      => 'hfch_apply_to_footer_options',
						'label'   => __( 'Apply to', 'header-footer-custom-html' ),
						'type'    => 'select',
						'options' => array(
							'all'  => __( 'All Pages', 'header-footer-custom-html' ),
							'home' => __( 'Home Page Only', 'header-footer-custom-html' ),
							'page' => __( 'Specific Page', 'header-footer-custom-html' ),
							'post' => __( 'Specific post', 'header-footer-custom-html' ),
						),
					),
					array(
						'id'      => 'hfch_footer_page_field_id',
						'label'   => __( 'Select Page', 'header-footer-custom-html' ),

						'type'    => 'pages',
						'options' => array(
							'post_type' => 'page',
						),
					),
					array(
						'id'      => 'hfch_footer_post_field_id',
						'label'   => __( 'Select Post', 'header-footer-custom-html' ),
						'type'    => 'posts',
						'options' => array(
							'post_type' => 'post',
						),
					),
					array(
						'id'                => 'hfch_footer_html',
						'label'             => __( 'Html for footer', 'header-footer-custom-html' ),
						'desc'              => __( 'Html code in this area will go in footer after the footer content', 'header-footer-custom-html' ),
						'placeholder'       => __( 'Paste your html code here', 'header-footer-custom-html' ),
						'type'              => 'editor',
						'sanitize_callback' => 'sanitize_editor',
					),
					array(
						'id'      => 'hfch_footer_html_sticky',
						'label'   => __( 'Stick above Footer Html code section to', 'header-footer-custom-html' ),
						'desc'    => __( 'Sticky Option for above Footer Html code section', 'header-footer-custom-html' ),
						'type'    => 'select',
						'default' => '0',
						'options' => array(
							'none'   => 'None',
							'bottom' => 'bottom',
							'left'   => 'Left in footer',
							'right'  => 'Right in footer',
						),
					),
					array(
						'id'                => 'hfch_footer_bg_color',
						'label'             => __( 'Background color for Footer Html', 'header-footer-custom-html' ),
						'desc'              => __( 'Default color is #FFA500', 'header-footer-custom-html' ),
						'type'              => 'color',
						'default'			=> '#FFA500',
						'sanitize_callback' => 'sanitize_editor',
					),
					array(
						'id'      => 'hfch_footer_bg_image',
						'label'   => __( 'Background Image for Footer Html', 'header-footer-custom-html' ),
						'desc'    => __( 'Background Image', 'header-footer-custom-html' ),
						'type'    => 'media',
						'default' => '',
						'options' => array(
							'btn'       => 'Add Media',
							'max_width' => 150,
						),
					),
					array(
						'id'      => 'hfch_footer_html_bg_repeat',
						'label'   => __( "Footer html background Image Repeat property", 'header-footer-custom-html' ),
						'desc'    => __( 'Image background-repeat property', 'header-footer-custom-html' ),
						'type'    => 'select',
						'default' => 'no-repeat',
						'options' => array(
							'no-repeat'  => 'No Repeat',
							'repeat'  => 'Repeat',
						),
					),
					array(
						'id'      => 'hfch_footer_html_bg_position',
						'label'   => __( "Footer html background Image Position property", 'header-footer-custom-html' ),
						'desc'    => __( 'Image background-position property', 'header-footer-custom-html' ),
						'type'    => 'select',
						'default' => 'center',
						'options' => array(
							'top'  => 'Top',
							'center'  => 'Center',
							'bottom'  => 'Bottom',
						),
					),
					array(
						'id'      => 'hfch_footer_html_bg_attachment',
						'label'   => __( "Footer html image Background Attachement property", 'header-footer-custom-html' ),
						'desc'    => __( 'Image background-attachement property', 'header-footer-custom-html' ),
						'type'    => 'select',
						'default' => 'scroll',
						'options' => array(
							'scroll'  => 'Scroll',
							'fixed'  => 'Fixed',
							'initial'  => 'Initial',
							'inherit'  => 'Inherit',
						),
					),
					array(
						'id'      => 'hfch_footer_html_bg_size',
						'label'   => __( "Footer html image Background Size property", 'header-footer-custom-html' ),
						'desc'    => __( 'Image background-size property', 'header-footer-custom-html' ),
						'type'    => 'select',
						'default' => 'cover',
						'options' => array(
							'cover'  => 'Cover',
							'contain'  => 'Contain',
							'initial'  => 'Initial',
							'inherit'  => 'Inherit',
						),
					),
				),
				'hfch_script_css_section' => array(
					array(
						'id'      => 'hfch_apply_to_scriptcss_options',
						'label'   => __( 'Apply to', 'header-footer-custom-html' ),
						'type'    => 'select',
						'options' => array(
							'all'  => __( 'All Pages', 'header-footer-custom-html' ),
							'home' => __( 'Home Page Only', 'header-footer-custom-html' ),
							'page' => __( 'Specific Page', 'header-footer-custom-html' ),
							'post' => __( 'Specific post', 'header-footer-custom-html' ),
						),
					),
					array(
						'id'      => 'hfch_scriptcss_page_field_id',
						'label'   => __( 'Select Page', 'header-footer-custom-html' ),

						'type'    => 'pages',
						'options' => array(
							'post_type' => 'page',
						),
					),
					array(
						'id'      => 'hfch_scriptcss_post_field_id',
						'label'   => __( 'Select Post', 'header-footer-custom-html' ),
						'type'    => 'posts',
						'options' => array(
							'post_type' => 'post',
						),
					),
					array(
						'id'                => 'hfch_custom_css',
						'label'             => __( 'Custom CSS', 'header-footer-custom-html' ),
						'desc'              => __( 'Paste your custom CSS code above without any &lt;style&gt; or &lt;/style&gt; tags. Your css code will be rendered in head.', 'header-footer-custom-html' ),
						'placeholder'       => __( '', 'header-footer-custom-html' ),
						'type'              => 'editor',
						'sanitize_callback' => 'sanitize_editor',
					),
					array(
						'id'                => 'hfch_custom_script',
						'label'             => __( 'Custom Script', 'header-footer-custom-html' ),
						'desc'              => __( 'Add your js code or third party script code like google map library or facebook pixel codes including &lt;script&gt;,&lt;/script&gt; tags.<br><br> Your custom js code should be like this <br> &lt;script&gt;<br>...Your script code goes here...<br>&lt;/script&gt;', 'header-footer-custom-html' ),
						'placeholder'       => __( '', 'header-footer-custom-html' ),
						'type'              => 'htmleditor',
						'sanitize_callback' => 'sanitize_htmleditor',
					),
					array(
						'id'      => 'hfch_script_location',
						'label'   => __( 'Select where to render above js Script', 'header-footer-custom-html' ),
						'desc'    => __( 'Location to render above Custom js Script', 'header-footer-custom-html' ),
						'type'    => 'select',
						'default' => '0',
						'options' => array(
							'0' => 'Default (before head ends)',
							'1' => 'Before head ends',
							'2' => 'Before body ends',
						),
					),
				),

			),
		);

		new Enwb_Hfch_Boo_Settings_Helper( $header_footer_custom_html_settings );

	}

	/**
	 * Action links for admin.
	 *
	 * @param  array $links Array of action links.
	 * @return array
	 */
	public function plugin_action_links( $links ) {

		$settings_link = esc_url( add_query_arg( array( 'page' => 'header-footer-custom-html' ), admin_url( 'admin.php' ) ) );

		$new_links['settings'] = sprintf( '<a href="%1$s" title="%2$s">%2$s</a>', $settings_link, esc_attr__( 'Settings', 'header-footer-custom-html' ) );
		// phpcs:disable
		/*
		if ( ! class_exists( 'Header_Footer_Custom_Html_Pro' ) ){
			$pro_link = esc_url( add_query_arg( array( 'utm_source' => 'wp-admin-plugins', 'utm_medium' => 'go	-pro', 'utm_campaign' => 'header-footer-custom-html' ), 'https://www.enweby.com/shop/wordpress-plugins/header-footer-custom-html/' ) );
			$new_links[ 'go-pro' ] = sprintf( '<a target="_blank" style="color: #45b450; font-weight: bold;" href="%1$s" title="%2$s">%2$s</a>', $pro_link, esc_attr__('Go Pro', 'header-footer-custom-html' ) );
		}*/
		// phpcs:enable
		return array_merge( $links, $new_links );
	}

	/**
	 * Plugin row meta.
	 *
	 * @param  array  $links array of row meta.
	 * @param  string $file  plugin base name.
	 * @return array
	 */
	public function plugin_row_meta( $links, $file ) {
		// phpcs:ignore
		if ( $file === HEADER_FOOTER_CUSTOM_HTML_BASE_NAME ) {

			$report_url = add_query_arg(
				array(
					'utm_source'   => 'wp-admin-plugins',
					'utm_medium'   => 'row-meta-link',
					'utm_campaign' => 'header-footer-custom-html',
				),
				'https://www.enweby.com/product/header-footer-custom-html#support/'
			);

			$documentation_url = add_query_arg(
				array(
					'utm_source'   => 'wp-admin-plugins',
					'utm_medium'   => 'row-meta-link',
					'utm_campaign' => 'header-footer-custom-html',
				),
				'https://www.enweby.com/product/header-footer-custom-html#documentation/'
			);

			//$row_meta['documentation'] = sprintf( '<a target="_blank" href="%1$s" title="%2$s">%2$s</a>', esc_url( $documentation_url ), esc_html__( 'Documentation', 'header-footer-custom-html' ) );
			// phpcs:ignore
			$row_meta['issues'] = sprintf( '%2$s <a target="_blank" href="%1$s">%3$s</a>', esc_url( $report_url ), esc_html__( '', 'header-footer-custom-html' ), '<span style="color: #45b450;font-weight:bold;">' . esc_html__( 'Get Support', 'header-footer-custom-html' ) . '</span>' );

			return array_merge( $links, $row_meta );
		}
		return (array) $links;
	}
}
