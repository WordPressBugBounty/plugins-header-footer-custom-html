<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.enweby.com/
 * @since      1.0.0
 *
 * @package    Header_Footer_Custom_Html
 * @subpackage Header_Footer_Custom_Html/admin/partials
 */

?>
<style>
.enweby-popular-products ul li{padding:0 10px; -webkit-transition: all 0.4s ease 0s; -moz-transition: all 0.4s ease 0s;     -o-transition: all 0.4s ease 0s;   transition: all 0.4s ease 0s;}
.enweby-popular-products ul li a{text-decoration:none; -webkit-transition: all 0.4s ease 0s; -moz-transition: all 0.4s ease 0s;     -o-transition: all 0.4s ease 0s;   transition: all 0.4s ease 0s;}
.enweby-popular-products ul li:hover img{transform: scale(1.1);box-shadow:rgb(38 57 77) 0px 20px 30px -10px !important;-webkit-transition: all 0.5s ease 0s; -moz-transition: all 0.5s ease 0s;  -o-transition: all 0.5s ease 0s; transition: all 0.5s ease 0s;
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;
}
.enweby-popular-products ul li:hover a{color:#CF3F57;}
</style>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h2 class="enweby-plugin-title"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'images/enweby-logo.png'; ?>" title="Enweby Solutions" alt="Enweby Solutions" />Header footer Custom Html</h2>
<div class="enweby-popular-products">
	<label>Check other free & popular plugins by <span>Enweby</span></label>
	<div class="enweby-plugins">
		<ul>
			<li><a href="https://wordpress.org/plugins/enweby-variation-swatches-for-woocommerce/" target="_blank"><img title="Variation Swatches for WooCommerce" src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'images/enwbvs-128x128.png'; ?>"></a><p><a href="https://wordpress.org/plugins/enweby-variation-swatches-for-woocommerce/" target="_blank">Variation Swatches for WooCommerce</a></p></li>
			<li><a href="https://wordpress.org/plugins/header-footer-custom-html/" target="_blank"><img title="Header Footer Custom Htmlm" src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'images/hfch-128x128.png'; ?>"></a><p><a href="https://wordpress.org/plugins/header-footer-custom-html/" target="_blank">Header Footer Custom Html</a></p></li>
			<li><a href="https://wordpress.org/plugins/enweby-pretty-product-quick-view/" target="_blank"><img title="Variation Swatches for WooCommerce" src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'images/epqv-128x128.png'; ?>"></a><p><a href="https://wordpress.org/plugins/enweby-pretty-product-quick-view/" target="_blank">Pretty Product Quick View</a></p></li>
			<li><a href="https://wordpress.org/plugins/fullscreen-background/" target="_blank"><img title="Fullscreen Background" src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'images/fsbg-128x128.png'; ?>"></a><p><a href="https://wordpress.org/plugins/fullscreen-background/" target="_blank">Fullscreen Background</a></p></li>
			<li><a href="https://wordpress.org/plugins/offcanvas-menu/" target="_blank"><img title="Offcanvas Mombile Menu" src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) .'images/omm-128x128.jpg'; ?>"></a><p><a href="https://wordpress.org/plugins/offcanvas-menu/" target="_blank">Offcanvas Mobile Menu</a></p></li>
		</ul>
	</div>
</div>