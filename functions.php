<?php
/**
 * @package zeen101's Leaky Paywall - Subscriber Downloads
 * @since 1.0.0
 */

if ( !function_exists( 'leaky_paywall_mdo_server_download' ) ) {

	function leaky_paywall_mdo_server_download( $download_id ) {
	    // Grab the download info
		$url = wp_get_attachment_url( $download_id );
	    	
	    // Attempt to grab file
	    if ( $response = wp_remote_head( str_replace( ' ', '%20', $url ) ) ) {

	        if ( ! is_wp_error( $response ) ) {
	            $valid_response_codes = array(
	                200,
	            );
	            if ( in_array( wp_remote_retrieve_response_code( $response ), (array) $valid_response_codes ) ) {
		
	                // Get Resource Headers
	                $headers = wp_remote_retrieve_headers( $response );
	
	                // White list of headers to pass from original resource
	                $passthru_headers = array(
	                    'accept-ranges',
	                    'content-length',
	                    'content-type',
	                );
	
	                // Set Headers for download from original resource
	                foreach ( (array) $passthru_headers as $header ) {
	                    if ( isset( $headers[$header] ) )
	                        header( esc_attr( $header ) . ': ' . esc_attr( $headers[$header] ) );
	                }
	
	                // Set headers to force download
	                header( 'Content-Description: File Transfer' );
	                header( 'Content-Disposition: attachment; filename=' . basename( $url ) );
	                header( 'Content-Transfer-Encoding: binary' );
	                header( 'Expires: 0' );
	                header( 'Cache-Control: must-revalidate' );
	                header( 'Pragma: public' );
	
	                // Clear buffer
	                flush();
	
	                // Deliver the file: readfile, curl, redirect
	                if ( ini_get( 'allow_url_fopen' ) ) {
	                    // Use readfile if allow_url_fopen is on
	                    readfile( str_replace( ' ', '%20', $url )  );
	                } else if ( is_callable( 'curl_init' ) ) {
	                    // Use cURL if allow_url_fopen is off and curl is available
	                    $ch = curl_init( str_replace( ' ', '%20', $url ) );
	                    curl_exec( $ch );
	                    curl_close( $ch );
	                } else {
	                    // Just redirect to the file becuase their host <strike>sucks</strike> doesn't support allow_url_fopen or curl.
	                    wp_redirect( str_replace( ' ', '%20', $url ) );
	                }
	                die();
	
	            } else {
					$output = '<h3>' . __( 'Error Downloading File', 'lp-subscriber-downloads' ) . '</h3>';
		
					$output .= '<p>' . sprintf( __( 'Download Error: Invalid response: %s', 'lp-subscriber-downloads' ), wp_remote_retrieve_response_code( $response ) ) . '</p>';
					$output .= '<a href="' . get_home_url() . '">' . __( 'Home', 'lp-subscriber-downloads' ) . '</a>';
	            	
		            wp_die( $output );
	            }
	        } else {
				$output = '<h3>' . __( 'Error Downloading File', 'lp-subscriber-downloads' ) . '</h3>';
	
				$output .= '<p>' . sprintf( __( 'Download Error: %s', 'lp-subscriber-downloads' ), $response->get_error_message() ) . '</p>';
				$output .= '<a href="' . get_home_url() . '">' . __( 'Home', 'lp-subscriber-downloads' ) . '</a>';
            	
	            wp_die( $output );
	        }
	    }
	}
}