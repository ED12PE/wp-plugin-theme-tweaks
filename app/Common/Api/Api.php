<?php

namespace ThemeTweaks\App\Common\Api;

defined( 'ABSPATH' ) || exit;

class Api {
	public function __construct() {
		add_action('rest_api_init', function() {
			register_rest_route( 'theme-tweaks/v1', '/options', array(
				'methods' => 'POST',
				'callback' => array( $this, 'saveOptions' ),
				'permission_callback' => function() {
					return current_user_can( 'manage_options' );
				}
			));
		});
	}

	public function saveOptions( $request ) {
		var_dump( $request );
		exit;
		$options = $request->get_param( 'options' );
		update_option( 'theme_tweaks_options', $options );
		return new \WP_REST_Response( array( 'message' => 'Options saved' ), 200 );
	}
}