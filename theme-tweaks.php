<?php
/**
 * Plugin Name: Theme Tweaks
 * Plugin Uri: #
 * Description: Modifies native WordPress behavior focusing on better performance, security and long-term site management.
 * Author: Filipe Seabra
 * Author URI: #
 * Version: 2.0
 * Text Domain: theme-tweaks
 * Domain Path: /languages/
 */

defined( 'ABSPATH' ) || exit;

use ThemeTweaks\App\Main;

require_once __DIR__ . '/vendor/autoload.php';

// Create all necessary constants for this wordpress plugin.
define( 'THEME_TWEAKS_VERSION', '2.0' );
define( 'THEME_TWEAKS_PATH', plugin_dir_path( __FILE__ ) );
define( 'THEME_TWEAKS_URL', plugin_dir_url( __FILE__ ) );
define( 'THEME_TWEAKS_ASSETS', THEME_TWEAKS_URL . 'dist/' );
define( 'THEME_TWEAKS_SLUG', 'theme-tweaks' );

function themeTweaks(): Main {
	static $object = null;
	if ( ! isset( $object ) ) {
		$object = new Main();
	}

	return $object;
}

themeTweaks();