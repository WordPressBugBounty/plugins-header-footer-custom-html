<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.enweby.com/
 * @since      1.0.0
 *
 * @package    Header_Footer_Custom_Html
 * @subpackage Header_Footer_Custom_Html/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Header_Footer_Custom_Html
 * @subpackage Header_Footer_Custom_Html/public
 * @author     Enweby <support@enweby.com>
 */
class Header_Footer_Custom_Html_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/header-footer-custom-html-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/header-footer-custom-html-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Getting hfch settings meta relation id.
	 */
	public function enwb_hfch_settings_meta_relation_id( $the_id ) {
			$args = array(
			'posts_per_page'   => -1,
			'post_type' 	   => 'enwb_hfch_settings',
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'post_status'      => 'publish',
			'meta_query' => array(
				array(
					'key'     => 'enwb_hfch_settings_meta_relation',
					'value'   => $the_id,
					'compare' => '=',
				),
			),
		);

		$enwb_hfch_settings_post_data = get_posts( $args );
		if( count( $enwb_hfch_settings_post_data ) > 0 ) {
			return $enwb_hfch_settings_post_data[0]->ID;
		}
	}
	
	/**
	 * Getting Custom code page/post wise for header html
	 */	 
 	public function enweby_get_custom_html_header_single( $html ) {
	
		$custom_html_header_final = $html;
		
		//$enwb_hfch_settings_meta_relation_id = get_post_meta( get_the_ID(), 'enwb_hfch_settings_meta_relation', true );
		$enwb_hfch_settings_meta_relation_id = $this->enwb_hfch_settings_meta_relation_id( get_the_ID() );
		if( '' != $enwb_hfch_settings_meta_relation_id ) {
			$enwb_hfch_settings_meta_values = get_post_meta( $enwb_hfch_settings_meta_relation_id, 'enwb_hfch_settings_meta', true );
			
			$html_sticky_option_header = ( '' != $enwb_hfch_settings_meta_values['hfch-custom-header-html-stick-to'] ) ?  $enwb_hfch_settings_meta_values['hfch-custom-header-html-stick-to'] : 'none';
			$custom_html_header  = $enwb_hfch_settings_meta_values['hfch-custom-header-html'];
			$sticky_option_class       = 'enweby-hfch-sticky-header-' . $html_sticky_option_header;
			$custom_html_header        = ( isset( $custom_html_header ) && '' !== $custom_html_header ) ? '<div class="hfch-header ' . $sticky_option_class . '">' . $custom_html_header . '</div>' : '';

				
			if ( 'post' === $enwb_hfch_settings_meta_values['hfch-record-item-apply-to'] ) {
				if ( get_the_ID() === (int) $enwb_hfch_settings_meta_values['hfch_post_record_item_id'] ) {
					$custom_html_header_final = $custom_html_header;
				}
			}

			if ( 'page' === $enwb_hfch_settings_meta_values['hfch-record-item-apply-to'] ) {
				if ( get_the_ID() === (int) $enwb_hfch_settings_meta_values['hfch_page_record_item_id'] ) {
					$custom_html_header_final = $custom_html_header;
				}
			}
		}
		return $custom_html_header_final;
	}
	
	/**
	 * Getting Custom code page/post wise for footer html
	 */	 
 	public function enweby_get_custom_html_footer_single( $html ) {
	
		$custom_html_footer_final = $html;
		
		//$enwb_hfch_settings_meta_relation_id = get_post_meta( get_the_ID(), 'enwb_hfch_settings_meta_relation', true );
		$enwb_hfch_settings_meta_relation_id = $this->enwb_hfch_settings_meta_relation_id( get_the_ID() );
		if( '' != $enwb_hfch_settings_meta_relation_id ) {
			$enwb_hfch_settings_meta_values = get_post_meta( $enwb_hfch_settings_meta_relation_id, 'enwb_hfch_settings_meta', true );
			$html_sticky_option_footer = ( '' != $enwb_hfch_settings_meta_values['hfch-custom-footer-html-stick-to'] ) ?  $enwb_hfch_settings_meta_values['hfch-custom-footer-html-stick-to'] : 'none';
			$custom_html_footer = $enwb_hfch_settings_meta_values['hfch-custom-footer-html'];
			$sticky_option_class       = 'enweby-hfch-sticky-footer-' . $html_sticky_option_footer;
			$custom_html_footer        = ( isset( $custom_html_footer ) && '' !== $custom_html_footer ) ? '<div class="hfch-footer ' . $sticky_option_class . '">' . $custom_html_footer . '</div>' : '';

				
			if ( 'post' === $enwb_hfch_settings_meta_values['hfch-record-item-apply-to'] ) {
				if ( get_the_ID() === (int) $enwb_hfch_settings_meta_values['hfch_post_record_item_id'] ) {
					$custom_html_footer_final = $custom_html_footer;
				}
			}

			if ( 'page' === $enwb_hfch_settings_meta_values['hfch-record-item-apply-to'] ) {
				if ( get_the_ID() === (int) $enwb_hfch_settings_meta_values['hfch_page_record_item_id'] ) {
					$custom_html_footer_final = $custom_html_footer;
				}
			}
		}
		return $custom_html_footer_final;
	}
	
	/**
	 * Getting custom script page/post wise on header
	 */	 
 	public function enweby_get_custom_script_header_single( $script ) {
	
		$custom_script_header_final = $script;
		
		//$enwb_hfch_settings_meta_relation_id = get_post_meta( get_the_ID(), 'enwb_hfch_settings_meta_relation', true );
		$enwb_hfch_settings_meta_relation_id = $this->enwb_hfch_settings_meta_relation_id( get_the_ID() );
		if( '' != $enwb_hfch_settings_meta_relation_id ) {
			$enwb_hfch_settings_meta_values = get_post_meta( $enwb_hfch_settings_meta_relation_id, 'enwb_hfch_settings_meta', true );
				
			if ( 'post' === $enwb_hfch_settings_meta_values['hfch-record-item-apply-to'] ) {
				if ( get_the_ID() === (int) $enwb_hfch_settings_meta_values['hfch_post_record_item_id'] ) {
					$custom_script_header_final = $enwb_hfch_settings_meta_values['hfch-custom-js'];
				}
			}

			if ( 'page' === $enwb_hfch_settings_meta_values['hfch-record-item-apply-to'] ) {
				if ( get_the_ID() === (int) $enwb_hfch_settings_meta_values['hfch_page_record_item_id'] ) {
					$custom_script_header_final = $enwb_hfch_settings_meta_values['hfch-custom-js'];
				}
			}
		}
		return $custom_script_header_final;
	}
	
	/**
	 * Getting custom script render location page/post wise
	 */	 
 	public function enweby_get_custom_script_render_location_single( $render_location ) {
		$hfch_js_render_to_final = $render_location;
		$enwb_hfch_settings_meta_relation_id = $this->enwb_hfch_settings_meta_relation_id( get_the_ID() );
		if( '' != $enwb_hfch_settings_meta_relation_id ) {
			$enwb_hfch_settings_meta_values = get_post_meta( $enwb_hfch_settings_meta_relation_id, 'enwb_hfch_settings_meta', true );
					
			$hfch_js_render_to = ( '' != $enwb_hfch_settings_meta_values['hfch-js-render-to'] ) ?  $enwb_hfch_settings_meta_values['hfch-js-render-to'] : $render_location;
			$hfch_js_render_to_final = $hfch_js_render_to;
		}
		return $hfch_js_render_to_final;
	}	
	
	/**
	 * Getting custom script page/post wise on footer
	 */	 
 	public function enweby_get_custom_script_footer_single( $script ) {
	
		$custom_script_footer_final = $script;
		
		//$enwb_hfch_settings_meta_relation_id = get_post_meta( get_the_ID(), 'enwb_hfch_settings_meta_relation', true );
		$enwb_hfch_settings_meta_relation_id = $this->enwb_hfch_settings_meta_relation_id( get_the_ID() );
		if( '' != $enwb_hfch_settings_meta_relation_id ) {
			$enwb_hfch_settings_meta_values = get_post_meta( $enwb_hfch_settings_meta_relation_id, 'enwb_hfch_settings_meta', true );
			if ( 'post' === $enwb_hfch_settings_meta_values['hfch-record-item-apply-to'] ) {
				if ( get_the_ID() === (int) $enwb_hfch_settings_meta_values['hfch_post_record_item_id'] ) {
					$custom_script_footer_final = $enwb_hfch_settings_meta_values['hfch-custom-js'];
				}
			}

			if ( 'page' === $enwb_hfch_settings_meta_values['hfch-record-item-apply-to'] ) {
				if ( get_the_ID() === (int) $enwb_hfch_settings_meta_values['hfch_page_record_item_id'] ) {
					$custom_script_footer_final = $enwb_hfch_settings_meta_values['hfch-custom-js'];
				}
			}
		
		}
		
		return $custom_script_footer_final;
	}
	
	/**
	 * Getting custom css page/post wise on footer
	 */	 
 	public function enweby_get_custom_css_single( $css ) {
	
		$custom_css_final = $css;
		$extra_css_for_header_final = '';
		$extra_css_for_footer_final = '';
		//$enwb_hfch_settings_meta_relation_id = get_post_meta( get_the_ID(), 'enwb_hfch_settings_meta_relation', true );
		$enwb_hfch_settings_meta_relation_id = $this->enwb_hfch_settings_meta_relation_id( get_the_ID() );
		
		if( '' != $enwb_hfch_settings_meta_relation_id ) {
			$enwb_hfch_settings_meta_values = get_post_meta( $enwb_hfch_settings_meta_relation_id, 'enwb_hfch_settings_meta', true );
			$hfch_custom_css  = $enwb_hfch_settings_meta_values['hfch-custom-css'];
				
			if ( 'post' === $enwb_hfch_settings_meta_values['hfch-record-item-apply-to'] ) {
				if ( get_the_ID() === (int) $enwb_hfch_settings_meta_values['hfch_post_record_item_id'] ) {
					$custom_css_final = $hfch_custom_css;
				}
			}

			if ( 'page' === $enwb_hfch_settings_meta_values['hfch-record-item-apply-to'] ) {
				if ( get_the_ID() === (int) $enwb_hfch_settings_meta_values['hfch_page_record_item_id'] ) {
					$custom_css_final = $hfch_custom_css;
				}
			}
			
			$extra_css_for_header = '';
			$extra_css_for_header .= ( '' != $enwb_hfch_settings_meta_values['hfch-header-html-bg'] ) ? 'background-color:'.$enwb_hfch_settings_meta_values['hfch-header-html-bg'].'; ' : 'background-color:#FFA500';
			$header_html_background_image = ( '' !== $enwb_hfch_settings_meta_values['header_image_url'] ) ? $enwb_hfch_settings_meta_values['header_image_url'] : '';
			$extra_css_for_header .= ( '' != $header_html_background_image ) ? 'background-image:url("'.$header_html_background_image.'"); background-repeat:'.$enwb_hfch_settings_meta_values['hfch-header-bg-image-background-repeat'].'; background-position:'.$enwb_hfch_settings_meta_values['hfch-header-bg-image-background-position'].'; background-attachment:'.$enwb_hfch_settings_meta_values['hfch-header-bg-image-background-attachment'].'; background-size:'.$enwb_hfch_settings_meta_values['hfch-header-bg-image-background-size'].'; ' : '';
			$extra_css_for_header_final = ( '' != $extra_css_for_header ) ? '.hfch-header{' . $extra_css_for_header . '}' : ''; 
			
			$extra_css_for_footer = '';
			$extra_css_for_footer .= ( '' != $enwb_hfch_settings_meta_values['hfch-footer-html-bg'] ) ? 'background-color:'.$enwb_hfch_settings_meta_values['hfch-footer-html-bg'].'; ' : 'background-color:#FFA500';
			$footer_html_background_image = ( '' !== $enwb_hfch_settings_meta_values['footer_image_url'] ) ? $enwb_hfch_settings_meta_values['footer_image_url'] : '';
			$extra_css_for_footer .= ( '' != $footer_html_background_image ) ? 'background-image:url("'.$footer_html_background_image.'"); background-repeat:'.$enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-repeat'].'; background-position:'.$enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-position'].'; background-attachment:'.$enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-attachment'].'; background-size:'.$enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-size'].'; ' : '';
			$extra_css_for_footer_final = ( '' != $extra_css_for_header ) ? '.hfch-footer{' . $extra_css_for_footer . '}' : '';
		}
		
		return $custom_css_final.' '.$extra_css_for_header_final.' '.$extra_css_for_footer_final ;
	}	
	
	/**
	 * Getting Custom html code for header
	 *
	 * @since    1.0.0
	 */
	public function enweby_get_custom_html_header() {
		$custom_html_header        = get_option( 'enweby_hfch_header_html', '' );
		$html_sticky_option_header = get_option( 'enweby_hfch_header_html_sticky', 'none' );
		$sticky_option_class       = 'enweby-hfch-sticky-header-' . $html_sticky_option_header;
		$custom_html_header        = ( isset( $custom_html_header ) && '' !== $custom_html_header ) ? '<div class="hfch-header ' . $sticky_option_class . '">' . $custom_html_header . '</div>' : '';

		$custom_html_header_final            = '';
		$enweby_hfch_apply_to_header_options = get_option( 'enweby_hfch_apply_to_header_options', 'all' );

		if ( is_front_page() && 'home' === $enweby_hfch_apply_to_header_options ) {
			$custom_html_header_final = $custom_html_header;
		}

		if ( 'all' === $enweby_hfch_apply_to_header_options ) {
			$custom_html_header_final = $custom_html_header;
		}

		if ( 'post' === $enweby_hfch_apply_to_header_options ) {
			if ( get_the_ID() === (int) get_option( 'enweby_hfch_header_post_field_id', '' ) ) {
				$custom_html_header_final = $custom_html_header;
			}
		}

		if ( 'page' === $enweby_hfch_apply_to_header_options ) {
			if ( get_the_ID() === (int) get_option( 'enweby_hfch_header_page_field_id', '' ) ) {
				$custom_html_header_final = $custom_html_header;
			}
		}
				
		// phpcs:ignore 
		echo wp_kses_post( apply_filters( 'enweby_get_custom_html_header_filter', $custom_html_header_final ) );
	}


	/**
	 * Getting Custom html code for header
	 *
	 * @since    1.0.0
	 */
	public function enweby_get_custom_html_footer() {
		$custom_html_footer        = get_option( 'enweby_hfch_footer_html', '' );
		$html_sticky_option_footer = get_option( 'enweby_hfch_footer_html_sticky', 'none' );
		$sticky_option_class       = 'enweby-hfch-sticky-footer-' . $html_sticky_option_footer;
		$custom_html_footer        = ( isset( $custom_html_footer ) && '' !== $custom_html_footer ) ? '<div class="hfch-footer ' . $sticky_option_class . '">' . $custom_html_footer . '</div>' : '';

		$custom_html_footer_final            = '';
		$enweby_hfch_apply_to_footer_options = get_option( 'enweby_hfch_apply_to_footer_options', 'all' );

		if ( is_front_page() && 'home' === $enweby_hfch_apply_to_footer_options ) {
			$custom_html_footer_final = $custom_html_footer;
		}

		if ( 'all' === $enweby_hfch_apply_to_footer_options ) {
			$custom_html_footer_final = $custom_html_footer;
		}

		if ( 'post' === $enweby_hfch_apply_to_footer_options ) {
			if ( get_the_ID() === (int) get_option( 'enweby_hfch_footer_post_field_id', '' ) ) {
				$custom_html_footer_final = $custom_html_footer;
			}
		}

		if ( 'page' === $enweby_hfch_apply_to_footer_options ) {
			if ( get_the_ID() === (int) get_option( 'enweby_hfch_footer_page_field_id', '' ) ) {
				$custom_html_footer_final = $custom_html_footer;
			}
		}
		// phpcs:ignore 
		echo wp_kses_post( apply_filters( 'enweby_get_custom_html_footer_filter', $custom_html_footer_final ) );
	}

	/**
	 * Getting script code
	 *
	 * @since    1.0.0
	 */
	public function enweby_get_custom_script_header() {
		$custom_script_header                   = get_option( 'enweby_hfch_custom_script', '' );
		$hfch_script_location                   = get_option( 'enweby_hfch_script_location', '0' );
		$custom_script_header_final             = '';
		$enweby_hfch_apply_to_scriptcss_options = get_option( 'enweby_hfch_apply_to_scriptcss_options', 'all' );

		if ( is_front_page() && 'home' === $enweby_hfch_apply_to_scriptcss_options ) {
			$custom_script_header_final = $custom_script_header;
		}

		if ( 'all' === $enweby_hfch_apply_to_scriptcss_options ) {
			$custom_script_header_final = $custom_script_header;
		}

		if ( 'post' === $enweby_hfch_apply_to_scriptcss_options ) {
			if ( get_the_ID() === (int) get_option( 'enweby_hfch_scriptcss_post_field_id', '' ) ) {
				$custom_script_header_final = $custom_script_header;
			}
		}

		if ( 'page' === $enweby_hfch_apply_to_scriptcss_options ) {
			if ( get_the_ID() === (int) get_option( 'enweby_hfch_scriptcss_page_field_id', '' ) ) {
				$custom_script_header_final = $custom_script_header;
			}
		}
		$hfch_script_location = apply_filters( 'enweby_hfch_script_location_header_filter', $hfch_script_location );
		if ( 0 === (int) $hfch_script_location || 1 === (int) $hfch_script_location ) {
			// phpcs:ignore 
			echo apply_filters( 'enweby_get_custom_script_header_filter', $custom_script_header_final );

		}
	}

	/**
	 * Getting script code
	 *
	 * @since    1.0.0
	 */
	public function enweby_get_custom_script_footer() {
		$custom_script                          = get_option( 'enweby_hfch_custom_script', '' );
		$hfch_script_location                   = get_option( 'enweby_hfch_script_location', '0' );
		$custom_script_final                    = '';
		$enweby_hfch_apply_to_scriptcss_options = get_option( 'enweby_hfch_apply_to_scriptcss_options', 'all' );

		if ( is_front_page() && 'home' === $enweby_hfch_apply_to_scriptcss_options ) {
			$custom_script_final = $custom_script;
		}

		if ( 'all' === $enweby_hfch_apply_to_scriptcss_options ) {
			$custom_script_final = $custom_script;
		}

		if ( 'post' === $enweby_hfch_apply_to_scriptcss_options ) {
			if ( get_the_ID() === (int) get_option( 'enweby_hfch_scriptcss_post_field_id', '' ) ) {
				$custom_script_final = $custom_script;
			}
		}

		if ( 'page' === $enweby_hfch_apply_to_scriptcss_options ) {
			if ( get_the_ID() === (int) get_option( 'enweby_hfch_scriptcss_page_field_id', '' ) ) {
				$custom_script_final = $custom_script;
			}
		}
		$hfch_script_location = apply_filters( 'enweby_hfch_script_location_footer_filter', $hfch_script_location );
		if ( 2 === (int) $hfch_script_location ) {
			// phpcs:ignore
			echo apply_filters( 'enweby_get_custom_script_footer_filter', $custom_script_final );
		}
	}

	/**
	 * Getting Custom css and processing
	 *
	 * @since    1.0.0
	 */
	public function enweby_get_custom_css() {
		$custom_css                             = get_option( 'enweby_hfch_custom_css', '' );
		//$custom_css_filtered                    = wp_kses_post( apply_filters( 'enweby_get_global_custom_css_filter', $custom_css ) );
		$custom_css_filtered_final              = '';
		$custom_css_final						= '';
		$enweby_hfch_apply_to_scriptcss_options = get_option( 'enweby_hfch_apply_to_scriptcss_options', 'all' );

		if ( is_front_page() && 'home' === $enweby_hfch_apply_to_scriptcss_options ) {
			$custom_css_final = $custom_css;
		}

		if ( 'all' === $enweby_hfch_apply_to_scriptcss_options ) {
			$custom_css_final = $custom_css;
		}

		if ( 'post' === $enweby_hfch_apply_to_scriptcss_options ) {
			if ( get_the_ID() === (int) get_option( 'enweby_hfch_scriptcss_post_field_id', '' ) ) {
				$custom_css_final = $custom_css;
			}
		}

		if ( 'page' === $enweby_hfch_apply_to_scriptcss_options ) {
			if ( get_the_ID() === (int) get_option( 'enweby_hfch_scriptcss_page_field_id', '' ) ) {
				$custom_css_final = $custom_css;
			}
		}
		
		$extra_css_for_header = '';
		$extra_css_for_header .= ( '' != get_option( 'enweby_hfch_header_bg_color' ) ) ? 'background-color:'.get_option( 'enweby_hfch_header_bg_color', '#FFA500;' ).'; ' : 'background-color:#FFA500;';
		$header_html_background_image = ( '' !== get_option( 'enweby_hfch_header_bg_image', '' ) ) ? wp_get_attachment_image_src( get_option( 'enweby_hfch_header_bg_image', '' ), $size = 'full' ) : '';
		$extra_css_for_header .= ( '' != $header_html_background_image ) ? 'background-image:url("'.$header_html_background_image[0].'"); background-repeat:'.get_option( 'enweby_hfch_header_html_bg_repeat', 'no-repeat' ).'; background-position:'.get_option( 'enweby_hfch_header_html_bg_position', 'center' ).'; background-attachment:'.get_option( 'enweby_hfch_header_html_bg_attachment', 'scroll' ).'; background-size:'.get_option( 'enweby_hfch_header_html_bg_size', 'cover' ).'; ' : '';
		$extra_css_for_header_final = ( '' != $extra_css_for_header ) ? '.hfch-header{' . $extra_css_for_header . '}' : ''; 
		
		$extra_css_for_footer = '';
		$extra_css_for_footer .= ( '' != get_option( 'enweby_hfch_footer_bg_color', '' ) ) ? 'background-color:'.get_option( 'enweby_hfch_footer_bg_color', '#FFA500' ).'; ' : 'background-color:#FFA500;';
		$footer_html_background_image = ( '' !== get_option( 'enweby_hfch_footer_bg_image', '' ) ) ? wp_get_attachment_image_src( get_option( 'enweby_hfch_footer_bg_image', '' ), $size = 'full' ) : '';
		$extra_css_for_footer .= ( '' != $footer_html_background_image ) ? 'background-image:url("'.$footer_html_background_image[0].'"); background-repeat:'.get_option( 'enweby_hfch_footer_html_bg_repeat', 'no-repeat' ).'; background-position:'.get_option( 'enweby_hfch_footer_html_bg_position', 'center' ).'; background-attachment:'.get_option( 'enweby_hfch_footer_html_bg_attachment', 'scroll' ).'; background-size:'.get_option( 'enweby_hfch_footer_html_bg_size', 'cover' ).'; ' : '';
		$extra_css_for_footer_final = ( '' != $extra_css_for_header ) ? '.hfch-footer{' . $extra_css_for_footer . '}' : ''; 
		
		$custom_css_filtered_final = wp_kses_post( apply_filters( 'enweby_get_custom_css_filter', $extra_css_for_header_final . ' ' . $custom_css_final . ' '. $extra_css_for_footer_final ) );

		wp_add_inline_style( 'header-footer-custom-html', $custom_css_filtered_final ); // where header-footer-custom-html is plugin name.
	}
}
