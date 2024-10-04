<?php

namespace ThemeTweaks\App;

/* 
- Plugin Headers
- Install Webpack?
- Constants
- Add exit if accessed directly
- Main Class with plugin's name
- Internationalization
- Composer Autoload
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Plugin Constants
define( 'TT_PLUGIN_VERSION', '1.0.0' );


final class Main {
	public ?Common\Tweaks\Tweaks $tweaks = null;

	public function __construct() {
		$this->init();
	}

	private function init() {
		$this->load();
	}

	private function load() {
		$this->tweaks = new Common\Tweaks\Tweaks();
	}
}