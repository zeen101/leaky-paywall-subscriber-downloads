<?php
/**
 * Registers zeen101's Leaky Paywall class
 *
 * @package zeen101's Leaky Paywall
 * @since 1.0.0
 */

/**
 * This class registers the main functionality
 *
 * @since 1.0.0
 */
if ( ! class_exists( 'Leaky_Paywall_Subscriber_Downloads' ) ) {
	
	class Leaky_Paywall_Subscriber_Downloads {
		
		/**
		 * Class constructor, puts things in motion
		 *
		 * @since 1.0.0
		 */
		function __construct() {
					
			add_action( 'wp', array( $this, 'process_requests' ), 15 );
			
		}
		
		function process_requests() {

			if ( !isset( $_GET['leaky-paywall-media-download'] ) ) {
				return;
			}
								
			global $leaky_paywall;
			$lp_settings = $leaky_paywall->get_settings();
				
			if ( $this->user_can_download_file() ) {
			
				leaky_paywall_mdo_server_download( absint( $_GET['leaky-paywall-media-download'] ) );
			
			} else {
				
				$output = '<h3>' . __( 'Unauthorized Download', 'lp-subscriber-downloads' ) . '</h3>';
	
				$output .= '<p>' . sprintf( __( 'You must be <a href="%s">logged in</a> with a valid <a href="%s">subscription</a> to download this file.', 'lp-subscriber-downloads' ), get_page_link( $lp_settings['page_for_login'] ), get_page_link( $lp_settings['page_for_subscription'] ) ) . '</p>';
				$output .= '<a href="' . get_home_url() . '">' . sprintf( __( 'back to %s', 'lp-subscriber-downloads' ), $lp_settings['site_name'] ) . '</a>';
				
				wp_die( apply_filters( 'leaky_paywall_mdo_unauthorized_download_output', $output ) );
				
			}
			
		}

		//Admins or subscribed users can download PDFs
		protected function user_can_download_file() {

			if ( !is_user_logged_in() ) {
				return false;
			}
			
			if ( current_user_can( 'manage_options' ) ) {
				return true;
			}
		
			if ( leaky_paywall_user_has_access( wp_get_current_user() ) ) {
				return true;
			}
			
			return false;

		}
		
	}
	
}
