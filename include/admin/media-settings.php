<?php
/**
 * @package Admin
 */

class Leaky_Paywall_Subscriber_Downloads_Media_Settings {

	/**
	* Class constructor to register settings page
	*
	* @since 1.0
	*/
	public function __construct() {

		add_filter( 'attachment_fields_to_edit', array( $this, 'attachment_url_field' ), 10, 2 );
		add_filter( 'attachment_fields_to_edit', array( $this, 'attachment_level_access' ), 20, 2 );

		add_filter( 'attachment_fields_to_save', array( $this, 'save_fields' ), null, 2);

	}

	/**
	* Display the special Leaky Paywall Subscriber Download URL when viewing a media file in the admin
	*
	* @since 1.2.0
	*
	* @param array form_fields
	* @param object post
	* @return array
	*/
	public function attachment_url_field( $form_fields, $post ) {

	    $form_fields['lp-subscriber-downloads-url'] = array(
	        'label' => 'Leaky Paywall Subscriber<br> Download URL',
			'input' => 'text',
	        'value' => home_url() . '?leaky-paywall-media-download=' . $post->ID,
	        'helps' => 'This URL requires an active Leaky Paywall subscription to download file',
		);

	    return $form_fields;
	}

	public function attachment_level_access( $form_fields, $post )
	{

		$lp_subscriber_downloads_specific_levels = get_post_meta( $post->ID, '_lp_subscriber_downloads_specific_levels', true );

		if ( empty( $lp_subscriber_downloads_specific_levels ) ) {
			$lp_subscriber_downloads_specific_levels = array();
		}

		$levels = leaky_paywall_get_levels();
		$levels_html = '';

		foreach( $levels as $key => $level ) {

			if ( isset($level['deleted']) && $level['deleted'] ) {
				continue;
			}

			if ( in_array($key, $lp_subscriber_downloads_specific_levels ) ) {
				$checked = 'checked';
			} else {
				$checked = '';
			}

			$levels_html .= '<input type="checkbox" id="attachments-' . $post->ID . '-lp_subscriber_downloads_specific_levels" name="attachments['. $post->ID .'][lp_subscriber_downloads_specific_levels][' . $key . ']" value="' . $key . '" ' . $checked . ' >' . $level['label'] . '<br>';
		}

	    $form_fields['lp_subscriber_downloads_specific_levels'] = array(
	        'label' => 'Require Specific Level',
			'input' => 'html',
			'html'	=> $levels_html,
			'value'	=> $lp_subscriber_downloads_specific_levels,
	        'helps' => 'Require the user to have a specific subscription level before downloading. Leave all unchecked to allow any active subscriber to download.',
		);

	    return $form_fields;

	}

	public function save_fields( $post, $attachment )
	{

		if ( isset( $attachment['lp_subscriber_downloads_specific_levels'] ) ) {
	        update_post_meta( $post['ID'], '_lp_subscriber_downloads_specific_levels', $attachment['lp_subscriber_downloads_specific_levels'] );
	    } else {
	        update_post_meta( $post['ID'], '_lp_subscriber_downloads_specific_levels', array() );
	    }

	    return $post;

	}

}

new Leaky_Paywall_Subscriber_Downloads_Media_Settings();