	/**
 * All of the js for your public-facing functionality should be
 * included in this file.
 *
 * @link              https://www.enweby.com/
 * @since             1.0.0
 * @package           Woocommerce_Custom_Redirection_After_Addtocart
 */

(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(
		function() {

			if ( $( ".hfch_apply_to_header_options" ).find( 'option:selected' ).val() == "page" ) {
				$( ".hfch_header_page_field_id" ).show();
			}
			if ( $( ".hfch_apply_to_header_options" ).find( 'option:selected' ).val() == "post" ) {
				$( ".hfch_header_post_field_id" ).show();
			}
			if ( $( ".hfch_apply_to_footer_options" ).find( 'option:selected' ).val() == "page" ) {
				$( ".hfch_footer_page_field_id" ).show();
			}
			if ( $( ".hfch_apply_to_footer_options" ).find( 'option:selected' ).val() == "post" ) {
				$( ".hfch_footer_post_field_id" ).show();
			}
			if ( $( ".hfch_apply_to_scriptcss_options" ).find( 'option:selected' ).val() == "page" ) {
				$( ".hfch_scriptcss_page_field_id" ).show();
			}
			if ( $( ".hfch_apply_to_scriptcss_options" ).find( 'option:selected' ).val() == "post" ) {
				$( ".hfch_scriptcss_post_field_id" ).show();
			}
			
			if ( $( "#hfch-record-item-apply-to" ).find( 'option:selected' ).val() == "page" ) {
				$( "#hfch_page_record_item_id" ).show();
			}
			if ( $( "#hfch-record-item-apply-to" ).find( 'option:selected' ).val() == "post" ) {
				$( "#hfch_post_record_item_id" ).show();
			}
			
			if ( '' != $('.hfch_header_bg_image img').attr('src') ) {
				$(".hfch_header_html_bg_repeat, .hfch_header_html_bg_position, .hfch_header_html_bg_attachment, .hfch_header_html_bg_size").show();
			}
			
			if ( '' != $('.hfch_footer_bg_image img').attr('src') ) {
				$(".hfch_footer_html_bg_repeat, .hfch_footer_html_bg_position, .hfch_footer_html_bg_attachment, .hfch_footer_html_bg_size").show();
			}
			
			if ( '' != $('.hfch_header_bg_image img').attr('src') ) {
				$(".hfch_header_html_bg_repeat, .hfch_header_html_bg_position, .hfch_header_html_bg_attachment, .hfch_header_html_bg_size").show();
			}
			
			if ( '' != $('.header_image_url-row #header_image_url').val() ) {
				$(".hfch-header-bg-image-background-size-row, .hfch-header-bg-image-background-attachment-row, .hfch-header-bg-image-background-position-row, .hfch-header-bg-image-background-repeat-row").show();
				$('#header_image_url_display').before("<span rel='#header_image_url' rel-assoc='header' class='hfch-img-remove-single'>x</span>");
			}
			
			if ( '' != $('.footer_image_url-row #footer_image_url').val() ) {
				$(".hfch-footer-bg-image-background-size-row, .hfch-footer-bg-image-background-attachment-row, .hfch-footer-bg-image-background-position-row, .hfch-footer-bg-image-background-repeat-row").show();
				$('#footer_image_url_display').before("<span rel='#footer_image_url' rel-assoc='footer' class='hfch-img-remove-single'>x</span>");	
			}
			
			
			// On changing.
			$( "#hfch-record-item-apply-to" ).change(
				function(){
					if ( $( "#hfch-record-item-apply-to" ).find( 'option:selected' ).val() == "page" ) {
						$( "#hfch_page_record_item_id" ).show();
						$( "#hfch_post_record_item_id" ).hide();
					}
					if ( $( "#hfch-record-item-apply-to" ).find( 'option:selected' ).val() == "post" ) {
						$( "#hfch_post_record_item_id" ).show();
						$( "#hfch_page_record_item_id" ).hide();
					}

				}
			);

			// On changing.
			$( ".hfch_apply_to_header_options" ).change(
				function(){
					if ( $( ".hfch_apply_to_header_options" ).find( 'option:selected' ).val() == "home" ) {
						$( ".hfch_header_post_field_id" ).hide();
						$( ".hfch_header_page_field_id" ).hide();
					}
					if ( $( ".hfch_apply_to_header_options" ).find( 'option:selected' ).val() == "all" ) {
						$( ".hfch_header_post_field_id" ).hide();
						$( ".hfch_header_page_field_id" ).hide();
					}
					if ( $( ".hfch_apply_to_header_options" ).find( 'option:selected' ).val() == "page" ) {
						$( ".hfch_header_page_field_id" ).show();
						$( ".hfch_header_post_field_id" ).hide();
					}
					if ( $( ".hfch_apply_to_header_options" ).find( 'option:selected' ).val() == "post" ) {
						$( ".hfch_header_post_field_id" ).show();
						$( ".hfch_header_page_field_id" ).hide();
					}

				}
			);
			// On changing.
			$( ".hfch_apply_to_footer_options" ).change(
				function(){
					if ( $( ".hfch_apply_to_footer_options" ).find( 'option:selected' ).val() == "home" ) {
						$( ".hfch_footer_post_field_id" ).hide();
						$( ".hfch_footer_page_field_id" ).hide();
					}
					if ( $( ".hfch_apply_to_footer_options" ).find( 'option:selected' ).val() == "all" ) {
						$( ".hfch_footer_post_field_id" ).hide();
						$( ".hfch_footer_page_field_id" ).hide();
					}
					if ( $( ".hfch_apply_to_footer_options" ).find( 'option:selected' ).val() == "page" ) {
						$( ".hfch_footer_page_field_id" ).show();
						$( ".hfch_footer_post_field_id" ).hide();
					}
					if ( $( ".hfch_apply_to_footer_options" ).find( 'option:selected' ).val() == "post" ) {
						$( ".hfch_footer_post_field_id" ).show();
						$( ".hfch_footer_page_field_id" ).hide();
					}

				}
			);
			// On changing.
			$( ".hfch_apply_to_scriptcss_options" ).change(
				function(){
					if ( $( ".hfch_apply_to_scriptcss_options" ).find( 'option:selected' ).val() == "home" ) {
						$( ".hfch_scriptcss_post_field_id" ).hide();
						$( ".hfch_scriptcss_page_field_id" ).hide();
					}
					if ( $( ".hfch_apply_to_scriptcss_options" ).find( 'option:selected' ).val() == "all" ) {
						$( ".hfch_scriptcss_post_field_id" ).hide();
						$( ".hfch_scriptcss_page_field_id" ).hide();
					}
					if ( $( ".hfch_apply_to_scriptcss_options" ).find( 'option:selected' ).val() == "page" ) {
						$( ".hfch_scriptcss_page_field_id" ).show();
						$( ".hfch_scriptcss_post_field_id" ).hide();
					}
					if ( $( ".hfch_apply_to_scriptcss_options" ).find( 'option:selected' ).val() == "post" ) {
						$( ".hfch_scriptcss_post_field_id" ).show();
						$( ".hfch_scriptcss_page_field_id" ).hide();
					}
				}
			);
			
			// Tabs.
			$( ".enwb-tabs li a" ).click(
				function(e){
					e.preventDefault();
					$( ".enwb-tabs li a" ).removeClass('active');
					$(this).addClass('active');
					$('.enwb-tab-content').removeClass('tab-content-active');
					$($(this).attr('rel')).addClass('tab-content-active');
				}
			);
			
			//initialize color picker on text box
			$( '.color-picker-field' ).wpColorPicker();
			
			//image upload
			 $('.image-upload-btn').click(function(e) {
					e.preventDefault();
					var rel_image_url = $(this).attr('rel');
					var image = wp.media({ 
						title: 'Upload Image',
						// mutiple: true if you want to upload multiple files at once
						multiple: false
					}).open()
					.on('select', function(e){
						// This will return the selected image from the Media Uploader, the result is an object
						var uploaded_image = image.state().get('selection').first();
						// We convert uploaded_image to a JSON object to make accessing it easier
						// Output to the console uploaded_image
						//console.log(uploaded_image);
						var image_url = uploaded_image.toJSON().url;
						// Let's assign the url value to the input field
											
						$(rel_image_url).val(image_url);
						$(rel_image_url+"_display").html("<img width='55px' src='"+image_url+"' />");
					});
				});
			
			$( ".hfch_header_bg_image .boospot-image-upload" ).click(function(){
				$(".hfch_header_html_bg_repeat, .hfch_header_html_bg_position, .hfch_header_html_bg_attachment, .hfch_header_html_bg_size").show();
			});
			$( ".hfch_footer_bg_image .boospot-image-upload" ).click(function(){
				$(".hfch_footer_html_bg_repeat, .hfch_footer_html_bg_position, .hfch_footer_html_bg_attachment, .hfch_footer_html_bg_size").show();
			});
			
			$( ".header_image_url-row #upload-btn" ).click(function(){
				$(".hfch-header-bg-image-background-size-row, .hfch-header-bg-image-background-attachment-row, .hfch-header-bg-image-background-position-row, .hfch-header-bg-image-background-repeat-row").show();
			});
			
			$( ".footer_image_url-row #upload-btn" ).click(function(){
				$(".hfch-footer-bg-image-background-size-row, .hfch-footer-bg-image-background-attachment-row, .hfch-footer-bg-image-background-position-row, .hfch-footer-bg-image-background-repeat-row").show();
			});
			
			$( ".hfch-img-remove-single" ).click(function(){
				$( $( this ).attr('rel')).val('');
				$( this ).parent().children( '.hfch-html-img-display' ).remove();
				$( '.'+$( this ).attr('rel-assoc' )+'-rel-bg-select').prop( "selectedIndex", 0 );
				$( this ).remove();
				
			});
			
			$( "#hfch-record-item-apply-to" ).change(function(){
				$( '#hfch_post_record_item_id').prop( "selectedIndex", 0 );
				$( '#hfch_page_record_item_id').prop( "selectedIndex", 0 );
			});
			
			$( "#hfch_post_record_item_id" ).change(function(){
				if ( "post" == $( "#hfch-record-item-apply-to" ).val() )
				{
					$("#postexcerpt #excerpt").val( $("#hfch_post_record_item_id").val() );
				}
			});
			
			$( "#hfch_page_record_item_id" ).change(function(){
				if ( "page" == $( "#hfch-record-item-apply-to" ).val() )
				{
					$("#postexcerpt #excerpt").val( $("#hfch_page_record_item_id").val() );
				}
			});
			
			
			//should be added at end off script to prevent conflict to above js code
			if( $('#hfch-custom-css').length ) {
				wp.codeEditor.initialize($('#hfch-custom-css'), enwb_hfch_settings);
			}
			if( $('#hfch-custom-js').length ) {
				//wp.codeEditor.initialize($('#hfch-custom-js'), enwb_hfch_settings);
			}
			if( $('#hfch_custom_css').length ) {
				wp.codeEditor.initialize($('#hfch_custom_css'), enwb_hfch_settings);
			}
			if( $('#hfch_custom_script').length ) {
				//wp.codeEditor.initialize($('#hfch_custom_script'), enwb_hfch_settings);
			}
		}
	);

})( jQuery );
