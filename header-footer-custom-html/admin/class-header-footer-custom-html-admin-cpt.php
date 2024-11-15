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
class Header_Footer_Custom_Html_CPT {

	/**
	 * Creates a new custom post type
	 *
	 * @since 1.0.0
	 * @access public
	 * @uses register_post_type()
	 */
	public static function new_cpt_slide() {

		$cap_type = 'post';
		$cpt_name = 'enwb_hfch_settings';

		$labels = array(
			'name'                  => esc_html_x( 'All Header Footer Settings', 'Post Type General Name', 'header-footer-custom-html' ),
			'singular_name'         => esc_html_x( 'Header Footer Custom Html', 'Post Type Singular Name', 'header-footer-custom-html' ),
			'menu_name'             => esc_html__( 'Header Footer Custom Html Records', 'header-footer-custom-html' ),
			'name_admin_bar'        => esc_html__( 'Header Footer Custom Html', 'header-footer-custom-html' ),
			'archives'              => esc_html__( 'Header Footer Custom Html Archives', 'header-footer-custom-html' ),
			'attributes'            => esc_html__( 'Header Footer Custom Html Attributes', 'header-footer-custom-html' ),
			'parent_item_colon'     => esc_html__( 'Header Footer Custom Html', 'header-footer-custom-html' ),
			'all_items'             => esc_html__( 'All header footer Records', 'header-footer-custom-html' ),
			'add_new_item'          => esc_html__( 'Add New header footer html, css, & js settings', 'header-footer-custom-html' ),
			'add_new'               => esc_html__( 'Add New', 'header-footer-custom-html' ),
			'new_item'              => esc_html__( 'New header footer setting', 'header-footer-custom-html' ),
			'edit_item'             => esc_html__( 'Edit header footer setting', 'header-footer-custom-html' ),
			'update_item'           => esc_html__( 'Update header footer setting', 'header-footer-custom-html' ),
			'view_item'             => esc_html__( 'View header footer setting', 'header-footer-custom-html' ),
			'view_items'            => esc_html__( 'View header footer settings', 'header-footer-custom-html' ),
			'search_items'          => esc_html__( 'Search header footer setting', 'header-footer-custom-html' ),
			'not_found'             => esc_html__( 'Not found', 'header-footer-custom-html' ),
			'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'header-footer-custom-html' ),
			//'featured_image'        => esc_html__( 'Featured Image', 'header-footer-custom-html' ),
			//'set_featured_image'    => esc_html__( 'Set featured image', 'header-footer-custom-html' ),
			//'remove_featured_image' => esc_html__( 'Remove featured image', 'header-footer-custom-html' ),
			//'use_featured_image'    => esc_html__( 'Use as featured image', 'header-footer-custom-html' ),
			'insert_into_item'      => esc_html__( 'Insert into header footer setting', 'header-footer-custom-html' ),
			'uploaded_to_this_item' => esc_html__( 'Uploaded to this header footer setting', 'header-footer-custom-html' ),
			'items_list'            => esc_html__( 'Header footer setting list', 'header-footer-custom-html' ),
			'items_list_navigation' => esc_html__( 'Header footer setting list navigation', 'header-footer-custom-html' ),
			'filter_items_list'     => esc_html__( 'Filter header footer setting list', 'header-footer-custom-html' ),
		);

		$args = array(
			'label'               => esc_html__( 'Header footer Custom Html', 'header-footer-custom-html' ),
			'description'         => esc_html__( 'A content type for adding header footer html and codes', 'header-footer-custom-html' ),
			'labels'              => $labels,
			'menu_icon'           => 'dashicons-welcome-view-site',
			'supports'            => array( 'title','excerpt'),
			'taxonomies'          => array( 'enwb_hcfh' ),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'menu_position'       => 5,
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'hierarchical'        => false,
			'exclude_from_search' => true,
			'show_in_rest'        => true,
			'publicly_queryable'  => false,
			'capability_type'     => $cap_type,
		);

		$args = apply_filters( 'enwb_hfch_cpt_options', $args );

		register_post_type( strtolower( $cpt_name ), $args );

	}
	
	/**
	 * Register meta boxes.
	 */
	function hfch_header_html_register_meta_boxes() {
		add_meta_box( 'hfch-header-html', __( 'Page/Post wise Header Footer Settings', 'header-footer-custom-html' ), array($this, 'hfch_header_html_callback' ), 'enwb_hfch_settings' );
	}
	
	/**
	 * Enqueing style and script
	 */
	function enwb_admin_enqueue_scripts() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_media();
		wp_enqueue_script( 'jquery' );
	}
	
	/**
	 * Adding Codemirror to editor.
	 */
	function codemirror_enqueue_scripts($hook) {
		$screen = get_current_screen();
		if ( in_array( $screen->id, array( 'enwb_hfch_settings', 'toplevel_page_header-footer-custom-html' ) ) ) {
			$enwb_hfch_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'css'));
		} else {
			$enwb_hfch_settings['codeEditor'] = array();	
		}
		
		wp_localize_script('jquery', 'enwb_hfch_settings', $enwb_hfch_settings);

		wp_enqueue_script('wp-theme-plugin-editor');
		wp_enqueue_style('wp-codemirror');
	}
	
	/**
	 * Retreiving all posts.
	 */
	function get_available_posts() {
		$default_args = array(
				'post_type'   => 'post',
				'numberposts' => - 1
			);

		$posts_args = wp_parse_args( $default_args );

		$posts = get_posts( $posts_args );

		$options = array(
			'' => '-- ' . __( 'Select Post' ) . ' --'
		);

		foreach ( $posts as $post ) :
			setup_postdata( $post );
			$options[ $post->ID ] = esc_html( $post->post_title );
			wp_reset_postdata();
		endforeach;

		// free memory
		unset( $posts, $posts_args, $default_args );

		//$this->callback_select( $args );	
		return $options;
	}
	
	/**
	 * Display pages dropdown.
	 *
	 */

	function get_dropdown_posts( $name, $id, $class, $selected_page ) {
		$all_posts = $this->get_available_posts();
		$slected_page_value = $selected_page;
		?>
		<select id='<?php echo $id; ?>' name='<?php echo $name; ?>' class='<?php echo $class; ?>' >
		<?php	
		foreach( $all_posts as $key => $label ) {
		?>
		<option value='<?php echo $key ?>' <?php selected( $slected_page_value, $key ); ?> ><?php echo $label; ?></option>
		<?php	
		}
		?>
		</select>
		<?php
	}
	
	/**
	 * Meta box display callback.
	 *
	 * @param WP_Post $post Current post object.
	 */

	function hfch_header_html_callback( $post ) {
			wp_nonce_field( 'hfch_meta_box_nonce_action', 'hfch_meta_box_nonce' );
			$enwb_hfch_settings_meta_values = get_post_meta( get_the_ID(), 'enwb_hfch_settings_meta', true );
			$hfch_record_item_apply_to = ( isset( $enwb_hfch_settings_meta_values['hfch-record-item-apply-to'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-record-item-apply-to'] ) ? $enwb_hfch_settings_meta_values['hfch-record-item-apply-to'] : 'page';
			$hfch_page_record_item_id = ( isset( $enwb_hfch_settings_meta_values['hfch_page_record_item_id'] ) && '' !== $enwb_hfch_settings_meta_values['hfch_page_record_item_id'] ) ? $enwb_hfch_settings_meta_values['hfch_page_record_item_id'] : '';
			$hfch_post_record_item_id = ( isset( $enwb_hfch_settings_meta_values['hfch_post_record_item_id'] ) && '' !== $enwb_hfch_settings_meta_values['hfch_post_record_item_id'] ) ? $enwb_hfch_settings_meta_values['hfch_post_record_item_id'] : '';
			
			$hfch_header_html_bg = ( isset( $enwb_hfch_settings_meta_values['hfch-header-html-bg'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-header-html-bg'] ) ? $enwb_hfch_settings_meta_values['hfch-header-html-bg'] : '#FFA500';
			$header_image_url = ( isset( $enwb_hfch_settings_meta_values['header_image_url'] ) && '' !== $enwb_hfch_settings_meta_values['header_image_url'] ) ? $enwb_hfch_settings_meta_values['header_image_url'] : esc_url( plugin_dir_url( __FILE__ ) . 'images/placeholder.svg' );
			$header_image_url_span = ( isset( $enwb_hfch_settings_meta_values['header_image_url'] ) && '' !== $enwb_hfch_settings_meta_values['header_image_url'] ) ? $enwb_hfch_settings_meta_values['header_image_url'] : '';
			$hfch_footer_html_bg = ( isset( $enwb_hfch_settings_meta_values['hfch-footer-html-bg'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-footer-html-bg'] ) ? $enwb_hfch_settings_meta_values['hfch-footer-html-bg'] : '#FFA500';
			$footer_image_url = ( isset( $enwb_hfch_settings_meta_values['footer_image_url'] ) && '' !== $enwb_hfch_settings_meta_values['footer_image_url'] ) ? $enwb_hfch_settings_meta_values['footer_image_url'] : esc_url( plugin_dir_url( __FILE__ ) . 'images/placeholder.svg' );
			$footer_image_url_span = ( isset( $enwb_hfch_settings_meta_values['footer_image_url'] ) && '' !== $enwb_hfch_settings_meta_values['footer_image_url'] ) ? $enwb_hfch_settings_meta_values['footer_image_url'] : '';
						
			$hfch_custom_header_html = ( isset( $enwb_hfch_settings_meta_values['hfch-custom-header-html'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-custom-header-html'] ) ? $enwb_hfch_settings_meta_values['hfch-custom-header-html'] : '';
			$hfch_custom_header_html_stick_to = ( isset( $enwb_hfch_settings_meta_values['hfch-custom-header-html-stick-to'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-custom-header-html-stick-to'] ) ? $enwb_hfch_settings_meta_values['hfch-custom-header-html-stick-to'] : 'none';
			$hfch_custom_footer_html = ( isset( $enwb_hfch_settings_meta_values['hfch-custom-footer-html'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-custom-footer-html'] ) ? $enwb_hfch_settings_meta_values['hfch-custom-footer-html'] : ''; 
			$hfch_custom_footer_html_stick_to = ( isset( $enwb_hfch_settings_meta_values['hfch-custom-footer-html-stick-to'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-custom-footer-html-stick-to'] ) ? $enwb_hfch_settings_meta_values['hfch-custom-footer-html-stick-to'] : 'none';
			
			$hfch_header_bg_image_background_repeat = ( isset( $enwb_hfch_settings_meta_values['hfch-header-bg-image-background-repeat'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-header-bg-image-background-repeat'] ) ? $enwb_hfch_settings_meta_values['hfch-header-bg-image-background-repeat'] : 'no-repeat';
			$hfch_header_bg_image_background_position = ( isset( $enwb_hfch_settings_meta_values['hfch-header-bg-image-background-position'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-header-bg-image-background-position'] ) ? $enwb_hfch_settings_meta_values['hfch-header-bg-image-background-position'] : 'center';
			$hfch_header_bg_image_background_attachment = ( isset( $enwb_hfch_settings_meta_values['hfch-header-bg-image-background-attachment'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-header-bg-image-background-attachment'] ) ? $enwb_hfch_settings_meta_values['hfch-header-bg-image-background-attachment'] : 'scroll';	
			$hfch_header_bg_image_background_size = ( isset( $enwb_hfch_settings_meta_values['hfch-header-bg-image-background-size'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-header-bg-image-background-size'] ) ? $enwb_hfch_settings_meta_values['hfch-header-bg-image-background-size'] : 'cover';	
			

			$hfch_footer_bg_image_background_repeat = ( isset( $enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-repeat'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-repeat'] ) ? $enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-repeat'] : 'no-repeat';
			$hfch_footer_bg_image_background_position = ( isset( $enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-position'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-position'] ) ? $enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-position'] : 'center';	
			$hfch_footer_bg_image_background_attachment = ( isset( $enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-attachment'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-attachment'] ) ? $enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-attachment'] : 'scroll';	
			$hfch_footer_bg_image_background_size = ( isset( $enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-size'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-size'] ) ? $enwb_hfch_settings_meta_values['hfch-footer-bg-image-background-size'] : 'cover';	
			
			
			$hfch_custom_css = ( isset( $enwb_hfch_settings_meta_values['hfch-custom-css'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-custom-css'] ) ? $enwb_hfch_settings_meta_values['hfch-custom-css'] : '';
			$hfch_custom_js = ( isset( $enwb_hfch_settings_meta_values['hfch-custom-js'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-custom-js'] ) ? $enwb_hfch_settings_meta_values['hfch-custom-js'] : '';
			$hfch_js_render_to = ( isset( $enwb_hfch_settings_meta_values['hfch-js-render-to'] ) && '' !== $enwb_hfch_settings_meta_values['hfch-js-render-to'] ) ? $enwb_hfch_settings_meta_values['hfch-js-render-to'] : '1';
			?>
			<div class='apply-to-section enwb-row-section'>
				<div class='block-row'>
					<p class='label-p'><label for="hfch-header-html"><?php
						_e( 'Apply to', 'header-footer-custom-html' )
					?></label></p>
					
					<select class='select-box-medium' name='hfch-record-item-apply-to' id='hfch-record-item-apply-to' >
						<option value='page' <?php selected( $hfch_record_item_apply_to, "page" ) ?> ><?php _e( 'Page', 'header-footer-custom-html' ); ?></option>
						<option value='post' <?php selected( $hfch_record_item_apply_to, "post" ) ?> ><?php _e( 'Post', 'header-footer-custom-html' ); ?></option>
					</select>
				</div>
				<div class='block-row'>
				<p class='label-p'><label class='select-page-or-poste' for="page-or-post"><?php
						_e( 'Selected page/post', 'header-footer-custom-html' )
				?></label></p>
				
				<?php
				$selected_page = $hfch_page_record_item_id;
				$pages_args = array('post_type' => 'page', 'name' => 'hfch_page_record_item_id', 'id' =>'hfch_page_record_item_id', 'sort_column' => 'post_title', 'class' => 'select-box-medium', 'selected' => $selected_page, 'sort_order' => 'ASC', 'show_option_none' => '-- ' . __( 'Select Page' ) . ' --');
				wp_dropdown_pages( $pages_args );
				//print_r($all_posts);
				$selected_post = $hfch_post_record_item_id;
				$this->get_dropdown_posts( 'hfch_post_record_item_id', 'hfch_post_record_item_id', 'select-box-medium', $selected_post );
				?>
				</div>
			</div>
			<div class='enwb-tabs'>
				<ul>
					<li><a class='active' href='#' rel='#hfch-hch'><?php _e( 'Header Custom Html', 'header-footer-custom-html' ); ?></a></li>
					<li><a class='' href='#' rel='#hfch-fch'><?php _e( 'Footer Custom Html', 'header-footer-custom-html' ); ?></a></li>
					<li><a class='' href='#' rel='#hfch-ccs'><?php _e( 'Custom CSS & Script', 'header-footer-custom-html' ); ?></a></li>
				</ul>
			</div>
			<div class="enwb-row-section enwb-tab-content tab-content-active" id="hfch-hch">
				<div class='block-row'>
					<p class='label-p'><label for="hfch-header-html"><?php
						_e( 'Header Custom Html', 'header-footer-custom-html' )
					?></label></p>
					
					<?php wp_editor( $hfch_custom_header_html, 'hfch-custom-header-html', $settings = array( 'textarea_name' => 'hfch-custom-header-html', 'textarea_rows' => '10' )); ?>
					<span>** please use double quote while adding html attribute in your custom html in above editor like <strong>style="color:red"</strong>, <strong>class="custom"</strong>, etc. Single quote will be removed by Wp Editor because of security reasons.</span>
				</div>
				<div class='block-row'>
					<p class='label-p'><label for="hfch-custom-header-html-stick-to"><?php _e( 'Stick Header Custom Html section to', 'header-footer-custom-html' ) ?></label></p>
					<select id="hfch-custom-header-html-stick-to" name="hfch-custom-header-html-stick-to" class="widefat hfch-select">
						<option value="none" <?php selected( $hfch_custom_header_html_stick_to, "none" ) ?> ><?php _e( 'None', 'header-footer-custom-html' ); ?></option>
						<option value="top"  <?php selected( $hfch_custom_header_html_stick_to, "top" ) ?> ><?php _e( 'Top', 'header-footer-custom-html' ); ?></option>
						<option value="left" <?php selected( $hfch_custom_header_html_stick_to, "left" ) ?> ><?php _e( 'Left side in header', 'header-footer-custom-html' ); ?></option>
						<option value="right" <?php selected( $hfch_custom_header_html_stick_to, "right" ) ?> ><?php _e( 'Right side in header', 'header-footer-custom-html' ); ?></option>
					</select>
				</div>
				<div class='block-row'>
					<p class='label-p'><label for="hfch-header-html"><?php
						_e( 'Background Color for header html', 'header-footer-custom-html' )
					?></label></p>
					
					<input type='text' id='hfch-header-html-bg' name='hfch-header-html-bg' class='color-picker-field' value='<?php echo esc_html( $hfch_header_html_bg ); ?>'>
				</div>
				
				<div class='block-row header_image_url-row' style='display:flex;flex-direction:column;'>
					<p class='label-p'><label for="hfch-header-html"><?php
						_e( 'Background Image for header html', 'header-footer-custom-html' )
					?></label></p>
					
					<div class='hfch-image-upload-wrapper'>
						<span id="header_image_url_display" class='hfch-html-img-display'><img width='80px' src='<?php echo esc_url($header_image_url); ?>'></span>
						<input type="text" name="header_image_url" id="header_image_url" class="regular-text" value="<?php echo esc_url($header_image_url_span); ?>">
						<input type="button" rel="#header_image_url" name="upload-btn" id="upload-btn" class="button-secondary image-upload-btn" value="<?php _e( 'Add Image', 'header-footer-custom-html' ); ?>">
					</div>
				</div>
				
				<div class='block-row hfch-header-bg-image-background-repeat-row'>
					<p class='label-p'><label for="hfch-header-bg-image-background-repeat"><?php _e( 'Set header html background image background-repeat property', 'header-footer-custom-html' ) ?></label></p>
					<select id="hfch-header-bg-image-background-repeat" name="hfch-header-bg-image-background-repeat" class="widefat hfch-select header-rel-bg-select">
						<option value="no-repeat" <?php selected( $hfch_header_bg_image_background_repeat, "no-repeat" ) ?> ><?php _e( 'No Repeat', 'header-footer-custom-html' ); ?></option>
						<option value="repeat"  <?php selected( $hfch_header_bg_image_background_repeat, "repeat" ) ?> ><?php _e( 'Repeat', 'header-footer-custom-html' ); ?></option>
					</select>
				</div>
				<div class='block-row hfch-header-bg-image-background-position-row'>
					<p class='label-p'><label for="hfch-header-bg-image-background-position"><?php _e( 'Set header html background image background-position property', 'header-footer-custom-html' ) ?></label></p>
					<select id="hfch-header-bg-image-background-position" name="hfch-header-bg-image-background-position" class="widefat hfch-select header-rel-bg-select">
						<option value="top" <?php selected( $hfch_header_bg_image_background_position, "top" ) ?> ><?php _e( 'Top', 'header-footer-custom-html' ); ?></option>
						<option value="center"  <?php selected( $hfch_header_bg_image_background_position, "center" ) ?> ><?php _e( 'Center', 'header-footer-custom-html' ); ?></option>
						<option value="bottom"  <?php selected( $hfch_header_bg_image_background_position, "bottom" ) ?> ><?php _e( 'Bottom', 'header-footer-custom-html' ); ?></option>
					</select>
				</div>
				<div class='block-row hfch-header-bg-image-background-attachment-row'>
					<p class='label-p'><label for="hfch-header-bg-image-background-attachment"><?php _e( 'Set header html background image background-attachment property', 'header-footer-custom-html' ) ?></label></p>
					<select id="hfch-header-bg-image-background-attachment" name="hfch-header-bg-image-background-attachment" class="widefat hfch-select header-rel-bg-select">
						<option value="scroll" <?php selected( $hfch_header_bg_image_background_attachment, "scroll" ) ?> ><?php _e( 'Scroll', 'header-footer-custom-html' ); ?></option>
						<option value="fixed"  <?php selected( $hfch_header_bg_image_background_attachment, "fixed" ) ?> ><?php _e( 'Fixed', 'header-footer-custom-html' ); ?></option>
						<option value="initial"  <?php selected( $hfch_header_bg_image_background_attachment, "initial" ) ?> ><?php _e( 'Initial', 'header-footer-custom-html' ); ?></option>
						<option value="inherit"  <?php selected( $hfch_header_bg_image_background_attachment, "inherit" ) ?> ><?php _e( 'Inherit', 'header-footer-custom-html' ); ?></option>
					</select>
				</div>
				
				<div class='block-row hfch-header-bg-image-background-size-row'>
					<p class='label-p'><label for="hfch-header-bg-image-background-size"><?php _e( 'Set header html background image background-size property', 'header-footer-custom-html' ) ?></label></p>
					<select id="hfch-header-bg-image-background-size" name="hfch-header-bg-image-background-size" class="widefat hfch-select header-rel-bg-select">
						<option value="cover" <?php selected( $hfch_header_bg_image_background_size, "cover" ) ?> ><?php _e( 'Cover', 'header-footer-custom-html' ); ?></option>
						<option value="contain"  <?php selected( $hfch_header_bg_image_background_size, "contain" ) ?> ><?php _e( 'Contain', 'header-footer-custom-html' ); ?></option>
						<option value="initial"  <?php selected( $hfch_header_bg_image_background_size, "initial" ) ?> ><?php _e( 'Initial', 'header-footer-custom-html' ); ?></option>
						<option value="inherit"  <?php selected( $hfch_header_bg_image_background_size, "inherit" ) ?> ><?php _e( 'Inherit', 'header-footer-custom-html' ); ?></option>
					</select>
				</div>
				

			</div>
			<div class="enwb-row-section enwb-tab-content" id='hfch-fch'>
				<div class='block-row'>
					<p class='label-p'><label for="hfch-footer-html"><?php
						_e( 'Footer Custom Html', 'header-footer-custom-html' )
					?></label></p>					
					<?php wp_editor( $hfch_custom_footer_html, 'hfch-custom-footer-html', $settings = array( 'textarea_name' => 'hfch-custom-footer-html', 'textarea_rows' => '10' )); ?>
					<span>** please use double quote while adding html attribute in your custom html in above editor like <strong>style="color:red"</strong>, <strong>class="custom"</strong>, etc. Single quote will be removed by Wp Editor because of security reasons.</span>
				</div>
				<div class='block-row'>
					<p class='label-p'><label for="hfch-custom-footer-html-stick-to"><?php _e( 'Stick Footer Custom Html section to', 'header-footer-custom-html' ) ?></label></p>
					<select id="hfch-custom-footer-html-stick-to" name="hfch-custom-footer-html-stick-to" class="widefat hfch-select">
						<option value="none" <?php selected( $hfch_custom_footer_html_stick_to, "none" ) ?> ><?php _e( 'None', 'header-footer-custom-html' ); ?></option>
						<option value="bottom"  <?php selected( $hfch_custom_footer_html_stick_to, "bottom" ) ?> ><?php _e( 'Bottom', 'header-footer-custom-html' ); ?></option>
						<option value="left" <?php selected( $hfch_custom_footer_html_stick_to, "left" ) ?> ><?php _e( 'Left side in footer', 'header-footer-custom-html' ); ?></option>
						<option value="right" <?php selected( $hfch_custom_footer_html_stick_to, "right" ) ?> ><?php _e( 'Right side in footer', 'header-footer-custom-html' ); ?></option>
					</select>
				</div>
				
				<div class='block-row'>
					<p class='label-p'><label for="hfch-footer-html"><?php
						_e( 'Background Color for footer html', 'header-footer-custom-html' )
					?></label></p>
					
					<input type='text' id='hfch-footer-html-bg' name='hfch-footer-html-bg' class='color-picker-field' value='<?php echo esc_html( $hfch_footer_html_bg ); ?>'>
				</div>
				
				<div class='block-row footer_image_url-row' style='display:flex;flex-direction:column;'>
					<p class='label-p'><label for="hfch-header-html"><?php
						_e( 'Background Image for footer html', 'header-footer-custom-html' )
					?></label></p>
					
					<div class='hfch-image-upload-wrapper'>
						<span id="footer_image_url_display" class='hfch-html-img-display'><img width='80px' src='<?php echo esc_url($footer_image_url); ?>'></span>
						<input type="text" name="footer_image_url" id="footer_image_url" class="regular-text" value="<?php echo esc_url($footer_image_url_span); ?>">
						<input type="button" rel="#footer_image_url" name="upload-btn" id="upload-btn" class="button-secondary image-upload-btn" value="<?php _e( 'Add Image', 'header-footer-custom-html' ); ?>">
					</div>
				</div>
			
				<div class='block-row hfch-footer-bg-image-background-repeat-row'>
					<p class='label-p'><label for="hfch-footer-bg-image-background-repeat"><?php _e( 'Set footer html background image background-repeat property', 'header-footer-custom-html' ) ?></label></p>
					<select id="hfch-footer-bg-image-background-repeat" name="hfch-footer-bg-image-background-repeat" class="widefat hfch-select footer-rel-bg-select">
						<option value="no-repeat" <?php selected( $hfch_footer_bg_image_background_repeat, "no-repeat" ) ?> ><?php _e( 'No Repeat', 'header-footer-custom-html' ); ?></option>
						<option value="repeat"  <?php selected( $hfch_footer_bg_image_background_repeat, "repeat" ) ?> ><?php _e( 'Repeat', 'header-footer-custom-html' ); ?></option>
					</select>
				</div>
				<div class='block-row hfch-footer-bg-image-background-position-row'>
					<p class='label-p'><label for="hfch-footer-bg-image-background-position"><?php _e( 'Set footer html background image background-position property', 'header-footer-custom-html' ) ?></label></p>
					<select id="hfch-footer-bg-image-background-position" name="hfch-footer-bg-image-background-position" class="widefat hfch-select footer-rel-bg-select">
						<option value="top" <?php selected( $hfch_footer_bg_image_background_position, "top" ) ?> ><?php _e( 'Top', 'header-footer-custom-html' ); ?></option>
						<option value="center"  <?php selected( $hfch_footer_bg_image_background_position, "center" ) ?> ><?php _e( 'Center', 'header-footer-custom-html' ); ?></option>
						<option value="bottom"  <?php selected( $hfch_footer_bg_image_background_position, "bottom" ) ?> ><?php _e( 'Bottom', 'header-footer-custom-html' ); ?></option>
					</select>
				</div>
				<div class='block-row hfch-footer-bg-image-background-attachment-row'>
					<p class='label-p'><label for="hfch-footer-bg-image-background-attachment"><?php _e( 'Set footer html background image background-attachment property', 'header-footer-custom-html' ) ?></label></p>
					<select id="hfch-footer-bg-image-background-attachment" name="hfch-footer-bg-image-background-attachment" class="widefat hfch-select footer-rel-bg-select">
						<option value="scroll" <?php selected( $hfch_footer_bg_image_background_attachment, "scroll" ) ?> ><?php _e( 'Scroll', 'header-footer-custom-html' ); ?></option>
						<option value="fixed"  <?php selected( $hfch_footer_bg_image_background_attachment, "fixed" ) ?> ><?php _e( 'Fixed', 'header-footer-custom-html' ); ?></option>
						<option value="initial"  <?php selected( $hfch_footer_bg_image_background_attachment, "initial" ) ?> ><?php _e( 'Initial', 'header-footer-custom-html' ); ?></option>
						<option value="inherit"  <?php selected( $hfch_footer_bg_image_background_attachment, "inherit" ) ?> ><?php _e( 'Inherit', 'header-footer-custom-html' ); ?></option>
					</select>
				</div>
				
				<div class='block-row hfch-footer-bg-image-background-size-row'>
					<p class='label-p'><label for="hfch-footer-bg-image-background-size"><?php _e( 'Set footer html background image background-size property', 'header-footer-custom-html' ) ?></label></p>
					<select id="hfch-footer-bg-image-background-size" name="hfch-footer-bg-image-background-size" class="widefat hfch-select footer-rel-bg-select">
						<option value="cover" <?php selected( $hfch_footer_bg_image_background_size, "cover" ) ?> ><?php _e( 'Cover', 'header-footer-custom-html' ); ?></option>
						<option value="contain"  <?php selected( $hfch_footer_bg_image_background_size, "contain" ) ?> ><?php _e( 'Contain', 'header-footer-custom-html' ); ?></option>
						<option value="initial"  <?php selected( $hfch_footer_bg_image_background_size, "initial" ) ?> ><?php _e( 'Initial', 'header-footer-custom-html' ); ?></option>
						<option value="inherit"  <?php selected( $hfch_footer_bg_image_background_size, "inherit" ) ?> ><?php _e( 'Inherit', 'header-footer-custom-html' ); ?></option>
					</select>
				</div>
			

			</div>
			<div class="enwb-row-section enwb-tab-content" id='hfch-ccs'>
				<div class='block-row'>
					<p class='label-p'><label for="hfch-custom-css"><?php
						_e( 'Custom Css', 'header-footer-custom-html' )
					?></label></p>					
					<textarea name='hfch-custom-css' id='hfch-custom-css' placeholder='' cols='120' rows='10'><?php echo wp_kses_post( $hfch_custom_css ); ?></textarea>
					<span>Paste your custom CSS code above without any &lt;style&gt; or &lt;/style&gt; tags. Your css code will be rendered in head.</span>
				</div>				
				<div class='block-row'>
					<p class='label-p'><label for="hfch-custom-js"><?php
						_e( 'Custom Js', 'header-footer-custom-html' )
					?></label></p>
					<textarea name='hfch-custom-js' placeholder='' class='hfch-script-textarea' id='hfch-custom-js' cols='120' rows='10'><?php echo $hfch_custom_js; ?></textarea>
					<span>Add your js code or third party script code like google map library or facebook pixel codes including &lt;script&gt;,&lt;/script&gt; tags.<br><br> Your custom js code should be like this <br> &lt;script&gt;<br>...Your script code goes here...<br>&lt;/script&gt;</span>
				</div>			
				<div class='block-row'>
					<p class='label-p'><label for="hfch-js-render-to"><?php _e( 'Select where to render custom js Script', 'header-footer-custom-html' ); ?></label></p>
					<select id="hfch-js-render-to" name="hfch-js-render-to" class="widefat hfch-select">
						<option value="1"  <?php selected( $hfch_js_render_to, "1" ) ?> ><?php _e( 'Before head ends (Default)', 'header-footer-custom-html' ); ?></option>
						<option value="2" <?php selected( $hfch_js_render_to, "2" ) ?> ><?php _e( 'Before body ends', 'header-footer-custom-html' ); ?></option>
					</select>
				</div>
			</div>
		<?php	
	}

	/**
	 * Saving Custom fields for CPT: book
	 */
	public function metabox_save_hfch_meta( $post_id, $post, $update ) {

		/**
		 * Prevent saving if its triggered for:
		 *  1. Auto save
		 *  2. User does not have permission to edit
		 *  3. invalid nonce
		 */

		// if this is an autosave, our form has not been submitted, so do nothing
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}


		// check user permission
		if ( ! current_user_can( 'edit_posts', $post_id ) ) {
			print __( 'Sorry, you do not have access to edit post', 'header-footer-custom-html' );
			exit;
		}


		// Verify Nonce
		if (
			! isset( $_POST['hfch_meta_box_nonce'] )
			||
			! wp_verify_nonce(
				$_POST['hfch_meta_box_nonce'],
				'hfch_meta_box_nonce_action'
			)
		) {
			return null;
		}


		/**
		 * We are good to process data.
		 */
		$hfch_meta_values = array();
		
		if ( array_key_exists( 'hfch-record-item-apply-to', $_POST ) ) {
		
			$hfch_meta_values ['hfch-record-item-apply-to'] = sanitize_text_field( wp_unslash( $_POST['hfch-record-item-apply-to'] ) ); // should be sanitized	
		}
		
		if ( array_key_exists( 'hfch_page_record_item_id', $_POST ) ) {
			$hfch_page_record_item_id_posted_var =( 'page' == $_POST['hfch-record-item-apply-to'] ) ? $_POST['hfch_page_record_item_id'] : '';
			$hfch_meta_values ['hfch_page_record_item_id'] = absint( $hfch_page_record_item_id_posted_var ); // should be sanitized
			
		}
		
		if ( array_key_exists( 'hfch_post_record_item_id', $_POST ) ) {
			$hfch_post_record_item_id_posted_var =( 'post' == $_POST['hfch-record-item-apply-to'] ) ? $_POST['hfch_post_record_item_id'] : '';
			$hfch_meta_values ['hfch_post_record_item_id'] = absint( $hfch_post_record_item_id_posted_var ); // should be sanitized	
		}
		
		if ( array_key_exists( 'hfch-header-html-bg', $_POST ) ) {
			$hfch_meta_values ['hfch-header-html-bg'] = sanitize_text_field( wp_unslash( $_POST['hfch-header-html-bg'] ) ); // should be sanitized
		}
		
		if ( array_key_exists( 'header_image_url', $_POST ) ) {
			$hfch_meta_values ['header_image_url'] = sanitize_text_field( wp_unslash( $_POST['header_image_url'] ) ); // should be sanitized
		}
		
		if ( array_key_exists( 'hfch-header-bg-image-background-repeat', $_POST ) ) {
			$hfch_meta_values ['hfch-header-bg-image-background-repeat'] = sanitize_text_field( wp_unslash( $_POST['hfch-header-bg-image-background-repeat'] ) ); // should be sanitized
		}
		
		if ( array_key_exists( 'hfch-header-bg-image-background-position', $_POST ) ) {
			$hfch_meta_values ['hfch-header-bg-image-background-position'] = sanitize_text_field( wp_unslash( $_POST['hfch-header-bg-image-background-position'] ) ); // should be sanitized
		}
		
		if ( array_key_exists( 'hfch-header-bg-image-background-attachment', $_POST ) ) {
			$hfch_meta_values ['hfch-header-bg-image-background-attachment'] = sanitize_text_field( wp_unslash( $_POST['hfch-header-bg-image-background-attachment'] ) ); // should be sanitized
		}
		
		if ( array_key_exists( 'hfch-header-bg-image-background-size', $_POST ) ) {
			$hfch_meta_values ['hfch-header-bg-image-background-size'] = sanitize_text_field( wp_unslash( $_POST['hfch-header-bg-image-background-size'] ) ); // should be sanitized
		}
		
		if ( array_key_exists( 'hfch-footer-bg-image-background-repeat', $_POST ) ) {
			$hfch_meta_values ['hfch-footer-bg-image-background-repeat'] = sanitize_text_field( wp_unslash( $_POST['hfch-footer-bg-image-background-repeat'] ) ); // should be sanitized
		}
		
		if ( array_key_exists( 'hfch-footer-bg-image-background-position', $_POST ) ) {
			$hfch_meta_values ['hfch-footer-bg-image-background-position'] = sanitize_text_field( wp_unslash( $_POST['hfch-footer-bg-image-background-position'] ) ); // should be sanitized
		}
		
		if ( array_key_exists( 'hfch-footer-bg-image-background-attachment', $_POST ) ) {
			$hfch_meta_values ['hfch-footer-bg-image-background-attachment'] = sanitize_text_field( wp_unslash( $_POST['hfch-footer-bg-image-background-attachment'] ) ); // should be sanitized
		}
		
		if ( array_key_exists( 'hfch-footer-bg-image-background-size', $_POST ) ) {
			$hfch_meta_values ['hfch-footer-bg-image-background-size'] = sanitize_text_field( wp_unslash( $_POST['hfch-footer-bg-image-background-size'] ) ); // should be sanitized
		}
		
		if ( array_key_exists( 'hfch-custom-header-html', $_POST ) ) {
		
			$hfch_meta_values ['hfch-custom-header-html'] = wp_kses_post( $_POST['hfch-custom-header-html'] ); // should be sanitized	
		}

		if ( array_key_exists( 'hfch-custom-header-html-stick-to', $_POST ) ) {
			$hfch_custom_header_html_stick_to = (
			in_array(
				$_POST['hfch-custom-header-html-stick-to'],
				array(
					'none',
					'top',
					'left',
					'right'
				)
			) ) ? sanitize_key( $_POST['hfch-custom-header-html-stick-to'] ) : 'none';

			$hfch_meta_values ['hfch-custom-header-html-stick-to'] = sanitize_text_field( wp_unslash( $hfch_custom_header_html_stick_to ) ); // should be sanitized			
		}

		if ( array_key_exists( 'hfch-footer-html-bg', $_POST ) ) {
			$hfch_meta_values ['hfch-footer-html-bg'] = sanitize_text_field( wp_unslash( $_POST['hfch-footer-html-bg'] ) ); // should be sanitized
		}
		
		if ( array_key_exists( 'footer_image_url', $_POST ) ) {
			$hfch_meta_values ['footer_image_url'] = sanitize_text_field( wp_unslash( $_POST['footer_image_url'] ) ); // should be sanitized
		}
		
		if ( array_key_exists( 'hfch-custom-footer-html', $_POST ) ) {
			$hfch_meta_values ['hfch-custom-footer-html'] = wp_kses_post( $_POST['hfch-custom-footer-html'] ); // should be sanitized
		}

		if ( array_key_exists( 'hfch-custom-footer-html-stick-to', $_POST ) ) {
			$hfch_custom_footer_html_stick_to = (
			in_array(
				$_POST['hfch-custom-footer-html-stick-to'],
				array(
					'none',
					'bottom',
					'left',
					'right'
				)
			) ) ? sanitize_key( $_POST['hfch-custom-footer-html-stick-to'] ) : 'none';

			$hfch_meta_values ['hfch-custom-footer-html-stick-to'] = sanitize_text_field( wp_unslash( $hfch_custom_footer_html_stick_to ) ); // should be sanitized			
		}
		
		if ( array_key_exists( 'hfch-custom-css', $_POST ) ) {
			$hfch_meta_values ['hfch-custom-css'] = wp_kses_post( $_POST['hfch-custom-css'] ); // should be sanitized
		}
		if ( array_key_exists( 'hfch-custom-js', $_POST ) ) {
			$hfch_meta_values ['hfch-custom-js'] = $_POST['hfch-custom-js']; // should be sanitized
		}
		
		if ( array_key_exists( 'hfch-js-render-to', $_POST ) ) {
			$hfch_js_render_to = (
			in_array(
				$_POST['hfch-js-render-to'],
				array(
					'1',
					'2'
				)
			) ) ? sanitize_key( $_POST['hfch-js-render-to'] ) : '1';

			$hfch_meta_values ['hfch-js-render-to'] = absint ( $hfch_js_render_to ); // should be sanitized			
		}
		
		if ( array_key_exists( 'hfch-record-item-apply-to', $_POST ) ) {
			if( 'page' == $_POST['hfch-record-item-apply-to'] ) {
				if ( array_key_exists( 'hfch_page_record_item_id', $_POST ) ) {
					$hfch_data_tob_attached_to = $_POST['hfch_page_record_item_id'];
				}
			} else if( 'post' == $_POST['hfch-record-item-apply-to'] ) {
				if ( array_key_exists( 'hfch_post_record_item_id', $_POST ) ) {
					$hfch_data_tob_attached_to = $_POST['hfch_post_record_item_id'];
				}
			} else {
				$hfch_data_tob_attached_to = '';
			}
		}

		if(count($hfch_meta_values) > 0) {
			update_post_meta(
					$post_id,
					'enwb_hfch_settings_meta',
					$hfch_meta_values						
				);

			if ( '' != $hfch_data_tob_attached_to ) {
				update_post_meta(
					$post_id,
					'enwb_hfch_settings_meta_relation',
					$hfch_data_tob_attached_to
				);
			}
			
			
			
		}	
	}
		
		

	/**
	 * Creates a new admin column on the custom post type listing screen.
	 *
	 * @param string $columns    The name of the column to add.
	 * @access public
	 */
	public function add_hfch_columns( $columns ) {
		//pushing custom column before date column
		$pos1 = 2;
		$val1 = array( 'post_name' => __( 'Applied on Page/Post', 'header-footer-custom-html') );
		$columns = array_merge(array_slice($columns, 0, $pos1), $val1, array_slice($columns, $pos1));
		
		$pos2 = 3;
		$val2 = array( 'type' => __( 'Type', 'header-footer-custom-html') );
		$columns = array_merge(array_slice($columns, 0, $pos2), $val2, array_slice($columns, $pos2));
		
		return $columns;

	}

	
	/**
	 * Displays the Post/Page title as column
	 *
	 * @since 1.0.0
	 * @param string $column     The name of the column.
	 * @param int    $post_id    The id of the post.
	 * @access public
	 */
	public function add_hfch_columns_content( $column, $post_id ) {
		
		if ( 'post_name' === $column ) {
			echo get_the_title ( get_post($post_id)->post_excerpt );			
		}
		if ( 'type' === $column ) {
			echo get_post ( get_post( $post_id )->post_excerpt )->post_type;			
		}	

	}


}
