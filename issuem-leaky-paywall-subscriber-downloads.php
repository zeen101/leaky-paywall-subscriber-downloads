<?php
/**
 * Main PHP file used to for initial calls to IssueM's Leak Paywall classes and functions.
 *
 * @package IssueM's Leak Paywall - Subscriber Downloads
 * @since 1.0.0
 */
 
/*
Plugin Name: IssueM's Leaky Paywall - Subscriber Downloads
Plugin URI: http://zeen101.com/
Description: A premium leaky paywall add-on for WordPress and IssueM.
Author: IssueM Development Team
Version: 1.0.0
Author URI: http://zeen101.com/
Tags:
*/

//Define global variables...
if ( !defined( 'ZEEN101_STORE_URL' ) )
	define( 'ZEEN101_STORE_URL', 	'http://zeen101.com' );
	
define( 'ISSUEM_LP_MDO_NAME', 		'Leaky Paywall - Subscriber Downloads' );
define( 'ISSUEM_LP_MDO_SLUG', 		'issuem-leaky-paywall-subscriber-downloads' );
define( 'ISSUEM_LP_MDO_VERSION', 	'1.0.0' );
define( 'ISSUEM_LP_MDO_DB_VERSION', '1.0.0' );
define( 'ISSUEM_LP_MDO_URL', 		plugin_dir_url( __FILE__ ) );
define( 'ISSUEM_LP_MDO_PATH', 		plugin_dir_path( __FILE__ ) );
define( 'ISSUEM_LP_MDO_BASENAME', 	plugin_basename( __FILE__ ) );
define( 'ISSUEM_LP_MDO_REL_DIR', 	dirname( ISSUEM_LP_MDO_BASENAME ) );

/**
 * Instantiate Pigeon Pack class, require helper files
 *
 * @since 1.0.0
 */
function issuem_leaky_paywall_media_download_obfuscator_plugins_loaded() {
	
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'issuem/issuem.php' ) )
		define( 'ISSUEM_ACTIVE_LP_MDO', true );
	else
		define( 'ISSUEM_ACTIVE_LP_MDO', false );

	require_once( 'class.php' );

	// Instantiate the Pigeon Pack class
	if ( class_exists( 'IssueM_Leaky_Paywall_Media_Download_Obfuscator' ) ) {
		
		global $dl_pluginissuem_leaky_paywall_media_download_obfuscator;
		
		$dl_pluginissuem_leaky_paywall_media_download_obfuscator = new IssueM_Leaky_Paywall_Media_Download_Obfuscator();
		
		require_once( 'functions.php' );
			
		//Internationalization
		load_plugin_textdomain( 'issuem-lp-mdo', false, ISSUEM_LP_MDO_REL_DIR . '/i18n/' );
			
	}

}
add_action( 'plugins_loaded', 'issuem_leaky_paywall_media_download_obfuscator_plugins_loaded', 4815162342 ); //wait for the plugins to be loaded before init
