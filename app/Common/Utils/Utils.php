<?php

namespace ThemeTweaks\App\Common\Utils;

defined( 'ABSPATH' ) || exit;

/**
 * Service class for utilities.
 */
class Utils {
	use Assets;

	/**
	 * Retrieves the current admin screen.
	 *
	 * @return \WP_Screen|null Current screen object or null when screen not defined.
	 */
	public function getCurrentScreen() {
		if ( ! function_exists( 'get_current_screen' ) || ! is_admin() ) {
			return null;
		}

		return get_current_screen();
	}
}