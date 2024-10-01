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

function themeTweaks(): Main {
	static $object = null;
	if ( ! isset( $object ) ) {
		$object = new Main();
	}

	return $object;
}

themeTweaks();