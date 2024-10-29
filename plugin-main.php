<?php 
/*
Plugin Name: AZ Advanced Custom Scrollbar
Plugin URI: http://demo.azplugins.com/advanced-custom-scrollbar/
Description: This plugin will enable custom scrollbar in your wordpress site. You can change color & other setting from <a href="options-general.php?page=azasbwp_options">Option Panel</a>
Author: AZ Plugins
Author URI: https://azplugins.com
Version: 1.0.0
Text Domain: azasbwp
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Some Set-up
 */
define('AZASBWP_PL_ROOT_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '' );
define('AZASBWP_PL_ROOT_DIR', dirname( __FILE__ ) );
define('AZASBWP_PL_VERSION', '1.0.0');

/**
 * Include all files
 */
require_once( AZASBWP_PL_ROOT_DIR. '/admin/class.settings-api.php');
require_once( AZASBWP_PL_ROOT_DIR. '/admin/plugin-options.php');

/**
 * load text domain
 */
function azasbwp_load_textdomain() {
    load_plugin_textdomain( 'azasbwp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'azasbwp_load_textdomain' );

/**
 * Enqueue scripts
 */
function azasbwp_scripts() {
   // Latest jQuery from WordPress
   wp_enqueue_script('jquery');

   // Nice scroll
   wp_enqueue_script( 'jquery-nicescroll', AZASBWP_PL_ROOT_URL.'/assets/js/jquery.nicescroll.min.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'azasbwp_scripts');

/**
 * Admin enqueue scripts
 */
function azasbwp_admin_scripts(){
    wp_enqueue_style( 'azasbwp-admin', AZASBWP_PL_ROOT_URL.'/assets/css/admin.css');
}
add_action( 'admin_enqueue_scripts', 'azasbwp_admin_scripts');

/**
 * Activate custom scrollber
 */
function azasbwp_active() {?>
	<?php 
		$bar_status           = azasbwp_get_option( 'bar_status', 'azasbwp_settings' );
		$bar_status           = $bar_status ? $bar_status : "on";

		$bar_color            = azasbwp_get_option( 'bar_color', 'azasbwp_settings' );
		$bar_color            = $bar_color ? $bar_color : "#0099ff";

		$bar_bg_color         = azasbwp_get_option( 'bar_bg_color', 'azasbwp_settings' );
		$bar_bg_color         = $bar_bg_color ? $bar_bg_color : "false";

		$bar_width            = azasbwp_get_option( 'bar_width', 'azasbwp_settings' );
		$bar_width            = $bar_width ? $bar_width : "12px";
		
		$bar_border_style     = azasbwp_get_option( 'bar_border_style', 'azasbwp_settings' );
		$bar_border_style	  = $bar_border_style ? $bar_border_style : "none";

		$bar_border_radius    = azasbwp_get_option( 'bar_border_radius', 'azasbwp_settings' );
		$bar_border_radius    = $bar_border_radius ? $bar_border_radius : "5px";

		$bar_scroll_speed     = azasbwp_get_option( 'bar_scroll_speed', 'azasbwp_settings' );
		$bar_scroll_speed     = $bar_scroll_speed ? $bar_scroll_speed : 60;

		$bar_enable_auto_hide = azasbwp_get_option( 'bar_enable_auto_hide', 'azasbwp_settings' );
		$bar_enable_auto_hide = $bar_enable_auto_hide == "yes" ? 'true' : 'false';

		if($bar_status == 'on'):
	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("html").niceScroll({
				cursorcolor: "<?php echo esc_js( $bar_color ); ?>", // change cursor color in hex
				cursoropacitymin: 0, // change opacity when cursor is inactive (scrollabar "hidden" state), range from 1 to 0
			    cursoropacitymax: 1, // change opacity when cursor is active (scrollabar "visible" state), range from 1 to 0
			    cursorwidth: "<?php echo esc_js($bar_width); ?>", // cursor width in pixel (you can also write "5px")
			    cursorborder: "<?php echo esc_js($bar_border_style); ?>", // css definition for cursor border
			    cursorborderradius: "<?php echo esc_js($bar_border_radius); ?>", // border radius in pixel for cursor
			    zindex: "auto", // change z-index for scrollbar div
			    scrollspeed: parseInt(<?php echo esc_js($bar_scroll_speed); ?>), // scrolling speed
			    autohidemode: <?php echo esc_js($bar_enable_auto_hide); ?>, // how hide the scrollbar works
		        background: "<?php echo esc_js($bar_bg_color); ?>", // change css for rail background
		        scrollbarid: false // set a custom ID for nicescroll bars 
			});           
		});	
	</script>
	<?php
		endif;
}
add_action('wp_head', 'azasbwp_active');

/**
 * Add action links
 */
add_filter('plugin_action_links_az-advanced-custom-scrollbar-wordpress/plugin-main.php', 'azpscrollbar_action_links_add', 10, 4);
function azpscrollbar_action_links_add( $actions, $plugin_file, $plugin_data, $context ){

    $settings_page_link = sprintf( '<a href="%s">%s</a>',
        esc_url( get_admin_url() . 'options-general.php?page=azasbwp_options' ),
        esc_html__( 'Settings', 'azasbwp' )
    );

    array_unshift( $actions, $settings_page_link );

    return $actions;
}