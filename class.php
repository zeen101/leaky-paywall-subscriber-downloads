<?php
/**
 * Registers IssueM's Leaky Paywall class
 *
 * @package IssueM's Leaky Paywall
 * @since 1.0.0
 */

/**
 * This class registers the main issuem functionality
 *
 * @since 1.0.0
 */
if ( ! class_exists( 'IssueM_Leaky_Paywall_Media_Download_Obfuscator' ) ) {
	
	class IssueM_Leaky_Paywall_Media_Download_Obfuscator {
		
		/**
		 * Class constructor, puts things in motion
		 *
		 * @since 1.0.0
		 */
		function __construct() {
					
			add_action( 'wp', array( $this, 'process_requests' ), 15 );
			
		}
		
		function process_requests() {
								
			global $dl_pluginissuem_leaky_paywall;
			
			$issuem_settings = $dl_pluginissuem_leaky_paywall->get_settings();
			
			if ( !empty( $_REQUEST['leaky-paywall-media-download'] ) ) {
				
				//Admins or subscribed users can download PDFs
				if ( current_user_can( 'manage_options' ) || is_issuem_leaky_subscriber_logged_in() ) {
				
					issuem_leaky_paywall_mdo_server_download( $_REQUEST['leaky-paywall-media-download'] );
				
				} else {
					
					$output = '<h3>' . __( 'Unauthorize Download', 'issuem-lp-mdo' ) . '</h3>';
		
					$output .= '<p>' . sprintf( __( 'You must be <a href="%s">logged in</a> with a valid subscription to download this file.', 'issuem-lp-mdo' ), get_page_link( $issuem_settings['page_for_login'] ) ) . '</p>';
					$output .= '<a href="' . get_home_url() . '">' . sprintf( __( 'back to %s', 'issuem-lp-mdo' ), $issuem_settings['site_name'] ) . '</a>';
					
					wp_die( apply_filters( 'issuem_leaky_paywall_mdo_unauthorized_download_output', $output ) );
					
				}
				
			}
			
		}
		
	}
	
}
