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
if (!class_exists('Leaky_Paywall_Subscriber_Downloads')) {

	class Leaky_Paywall_Subscriber_Downloads
	{

		/**
		 * Class constructor, puts things in motion
		 *
		 * @since 1.0.0
		 */
		function __construct()
		{

			add_action('wp', array($this, 'process_requests'), 15);
		}

		function process_requests()
		{

			if (!isset($_GET['leaky-paywall-media-download'])) {
				return;
			}

			$media_id = absint($_GET['leaky-paywall-media-download']);
			global $leaky_paywall;
			$lp_settings = $leaky_paywall->get_settings();

			if ($this->user_can_download_file($media_id)) {

				leaky_paywall_subdown_server_download($media_id);
			} else {

				$lp_subscriber_downloads_specific_levels = get_post_meta($media_id, '_lp_subscriber_downloads_specific_levels', true);
				$user = wp_get_current_user();

				$output = '<h3>' . __('Unauthorized Download', 'lp-subscriber-downloads') . '</h3>';

				if (empty($lp_subscriber_downloads_specific_levels) && !is_user_logged_in()) {
					$output .= '<p>' . sprintf(__('You must be <a href="%s">logged in</a> with a valid <a href="%s">subscription</a> to download this file.', 'lp-subscriber-downloads'), get_page_link($lp_settings['page_for_login']), get_page_link($lp_settings['page_for_subscription'])) . '</p>';
				} else if (!empty($lp_subscriber_downloads_specific_levels) && is_user_logged_in() && !leaky_paywall_user_has_access($user)) {
					$output .= '<p>' . sprintf(__('You need an active <a href="%s">subscription</a> to download this file.', 'lp-subscriber-downloads'), get_page_link($lp_settings['page_for_subscription'])) . '</p>';
				} else if (!empty($lp_subscriber_downloads_specific_levels) && is_user_logged_in()) {
					$output .= '<p>' . sprintf(__('You need a different <a href="%s">subscription</a> to download this file.', 'lp-subscriber-downloads'), get_page_link($lp_settings['page_for_subscription'])) . '</p>';
				} else {
					$output .= '<p>' . sprintf(__('You must be <a href="%s">logged in</a> with a valid <a href="%s">subscription</a> to download this file.', 'lp-subscriber-downloads'), get_page_link($lp_settings['page_for_login']), get_page_link($lp_settings['page_for_subscription'])) . '</p>';
				}

				$output .= '<a href="' . get_home_url() . '">' . sprintf(__('back to %s', 'lp-subscriber-downloads'), $lp_settings['site_name']) . '</a>';

				wp_die(apply_filters('leaky_paywall_mdo_unauthorized_download_output', $output));
			}
		}

		//Admins or subscribed users can download PDFs
		protected function user_can_download_file($media_id)
		{

			if (!is_user_logged_in()) {
				return false;
			}

			if (current_user_can('manage_options')) {
				return true;
			}

			$user = wp_get_current_user();

			if (!leaky_paywall_user_has_access($user)) {
				return false;
			}

			$lp_subscriber_downloads_specific_levels = get_post_meta($media_id, '_lp_subscriber_downloads_specific_levels', true);

			// if there are no specific levels set on the file, then any active subscriber gets access to it
			if (empty($lp_subscriber_downloads_specific_levels)) {
				return true;
			}

			$level_ids = leaky_paywall_subscriber_current_level_ids();
			$matches = array_intersect($level_ids, $lp_subscriber_downloads_specific_levels);

			if (!empty($matches)) {
				return true;
			}

			return false;
		}
	}
}
