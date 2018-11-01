<?php
/**
 * Main PHP file used to for initial calls to zeen101's Leak Paywall classes and functions.
 *
 * @package zeen101's Leak Paywall - Subscriber Downloads
 * @since 1.0.0
 */
 
/*
Plugin Name: Leaky Paywall - Subscriber Downloads
Plugin URI: https://zeen101.com/
Description: Require users to have a valid Leaky Paywall subscription before downloading a file
Author: ZEEN101
Version: 1.2.0
Author URI: https://zeen101.com/
Tags: paywall, downloads
*/

//Define global variables...
if ( !defined( 'ZEEN101_STORE_URL' ) )
	define( 'ZEEN101_STORE_URL', 	'https://zeen101.com' );
	
define( 'LP_MDO_NAME', 		'Leaky Paywall - Subscriber Downloads' );
define( 'LP_MDO_SLUG', 		'leaky-paywall-subscriber-downloads' );
define( 'LP_MDO_VERSION', 	'1.2.0' );
define( 'LP_MDO_DB_VERSION', '1.0.0' );
define( 'LP_MDO_URL', 		plugin_dir_url( __FILE__ ) );
define( 'LP_MDO_PATH', 		plugin_dir_path( __FILE__ ) );
define( 'LP_MDO_BASENAME', 	plugin_basename( __FILE__ ) );
define( 'LP_MDO_REL_DIR', 	dirname( LP_MDO_BASENAME ) );

/**
 * Instantiate Pigeon Pack class, require helper files
 *
 * @since 1.0.0
 */
function leaky_paywall_media_download_obfuscator_plugins_loaded() {
	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'issuem/issuem.php' ) )
		define( 'ACTIVE_LP_MDO', true );
	else
		define( 'ACTIVE_LP_MDO', false );

	require_once( 'class.php' );
	
	if ( is_plugin_active( 'leaky-paywall/leaky-paywall.php' ) ) {
				
		// Instantiate the Pigeon Pack class
		if ( class_exists( 'Leaky_Paywall_Subscriber_Downloads' ) ) {
			
			global $leaky_paywall_subscriber_downloads;
			
			$leaky_paywall_subscriber_downloads = new Leaky_Paywall_Subscriber_Downloads();
			
			require_once( 'functions.php' );
				
			//Internationalization
			load_plugin_textdomain( 'lp-subscriber-downloads', false, LP_MDO_REL_DIR . '/i18n/' );
				
		}
		
	} else {
	
		add_action( 'admin_notices', 'leaky_paywall_media_download_obfuscator_requirement_nag' );
		
	}

}
add_action( 'plugins_loaded', 'leaky_paywall_media_download_obfuscator_plugins_loaded', 4815162342 ); //wait for the plugins to be loaded before init

function leaky_paywall_media_download_obfuscator_requirement_nag() {
	?>
	<div id="leaky-paywall-requirement-nag" class="update-nag">
		<?php _e( 'You must have the Leaky Paywall plugin activated to use the Leaky Subscriber Downloads plugin.' ); ?>
	</div>
	<?php
}
